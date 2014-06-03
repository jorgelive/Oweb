<?php

namespace Gopro\Vipac\DbprocesoBundle\Comun;
use \Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;


class Archivo extends ContainerAware{

    private $archivo;
    private $mensajes=array();
    private $setTablaSpecs;
    private $setColumnaSpecs;
    private $validCols;
    private $parsed;

    private $tablaSpecs;
    private $columnaSpecs;
    private $existentesRaw;
    private $existentesIndizados;
    private $existentesIndizadosMulti;
    private $existentesCustomRaw;
    private $existentesCustomIndizados;
    private $existentesCustomIndizadosMulti;
    private $existentesDescartados;
    private $camposCustom;
    private $archivoValido;

    public function getTablaSpecs(){
        return $this->tablaSpecs;
    }

    public function getColumnaSpecs(){
        return $this->columnaSpecs;
    }

    public function getArchivoValido(){
        return $this->archivoValido;
    }

    public function getMensajes(){
        return $this->mensajes;
    }

    private function setMensajes($mensaje){
        $this->mensajes[]=$mensaje;
        return $this;
    }

    public function getExistentesRaw(){
        return $this->existentesRaw;
    }

    public function getExistentesIndizados(){
        return $this->existentesIndizados;
    }

    private function setExistentesIndizados($existentesIndizados){
        $this->existentesIndizados=$existentesIndizados;
        return $this;
    }

    public function getExistentesIndizadosMulti(){
        return $this->existentesIndizadosMulti;
    }

    private function setExistentesIndizadosMulti($existentesIndizadosMulti){
        $this->existentesIndizadosMulti=$existentesIndizadosMulti;
        return $this;
    }

    private function setExistentesRaw($existentesRaw){
        $this->existentesRaw=$existentesRaw;
        return $this;
    }

    public function setCamposCustom($campos){
        $this->camposCustom=$campos;
        return $this;
    }

    public function getCamposCustom(){
        return $this->camposCustom;
    }

    public function getExistentesCustomIndizados(){
        return $this->existentesCustomIndizados;
    }

    private function setExistentesCustomIndizados($existentesCustomIndizados){
        $this->existentesCustomIndizados=$existentesCustomIndizados;
        return $this;
    }

    public function getExistentesCustomIndizadosMulti(){
        return $this->existentesCustomIndizadosMulti;
    }

    private function setExistentesCustomIndizadosMulti($existentesCustomIndizadosMulti){
        $this->existentesCustomIndizadosMulti=$existentesCustomIndizadosMulti;
        return $this;
    }

    public function getExistentesCustomRaw(){
        return $this->existentesCustomRaw;
    }

    private function setExistentesCustomRaw($existentesCustomRaw){
        $this->existentesCustomRaw=$existentesCustomRaw;
        return $this;
    }

    public function getExistentesDescartados(){
        return $this->existentesDescartados;
    }

    public function setExistentesDescartados($existentesDescartados){
        $this->existentesDescartados=$existentesDescartados;
        return $this;
    }

    public function setParametros($setTablaSpecs,$setColumnaSpecs){
        if(is_null($this->getArchivoValido())||is_null($this->getArchivoValido()->getAbsolutePath())){
            $this->setMensajes('El archivo no existe');
            return false;
        }
        $this->archivo=$this->getArchivoValido()->getAbsolutePath();
        $this->setTableSpecs=$setTablaSpecs;
        $this->setColumnaSpecs=$setColumnaSpecs;
        if(!is_null($setTablaSpecs)&&!isset($setTablaSpecs['tipo'])){
            $setTablaSpecs['tipo']='S';
        }
        if (!is_null($setTablaSpecs)){
            $this->tablaSpecs=$setTablaSpecs;
        }else{
            $this->tablaSpecs=array();
        }
        if (!is_null($setColumnaSpecs)){
            foreach($setColumnaSpecs as $columna):
                if(isset($columna['nombre'])){
                    $this->validCols[]=$columna['nombre'];
                    if (preg_match("/-/i", $columna['nombre'])) {
                        $nombres=explode('-',$columna['nombre']);

                    }else{
                        $nombres=array($columna['nombre']);
                    }
                    unset($columna['nombre']);
                    foreach($nombres as $nombre):
                        $this->columnaSpecs[$nombre]=$columna;
                        $this->columnaSpecs[$nombre]['nombre']=$nombre;
                        $this->tablaSpecs['columnas'][]=$nombre;
                        if(!isset($columna['proceso'])||(isset($columna['proceso'])&&$columna['proceso']=='si')){
                            $this->tablaSpecs['columnasProceso'][]=$nombre;
                        }
                        if(isset($columna['llave'])&&$columna['llave']=='si'){
                            $this->tablaSpecs['llaves'][]=$nombre;
                        }
                    endforeach;

                }else{
                    $this->validCols[]='noProcess';
                }
            endforeach;
        }else{
            $this->columnaSpecs=array();
            $this->validCols=array();
        }
        $this->existentesRaw=array();
        $this->existentesDescartados=array();
        $this->mensajes=array();
        $this->parsed='no';
    }

    public function parseExcel(){

        if($this->parsed=='si'){
            $this->setMensajes('El archivo ya fue procesado anteriormente');
            return true;
        }
        $this->parsed='si';

        $fs = new Filesystem();

        if(empty($this->archivo)||!$fs->exists($this->archivo)){
            $this->setMensajes('El archivo no existe');
            return false;
        }

        $excelLoader = $this->container->get('phpexcel');
        $objPHPExcel = $excelLoader->createPHPExcelObject($this->archivo);
        $total_sheets=$objPHPExcel->getSheetCount();
        $allSheetName=$objPHPExcel->getSheetNames();
        $objWorksheet = $objPHPExcel->setActiveSheetIndex(0);
        $highestRow = $objWorksheet->getHighestRow();
        $highestColumn = $objWorksheet->getHighestColumn();
        $highestColumnIndex = $excelLoader->columnIndexFromString($highestColumn);
        $specRow=false;
        $specRowType='';
        $existentesRaw=array();
        $existentesIndizados=array();
        $existentesIndizadosMulti=array();
        $fila=0;
        for ($row = 1; $row <= $highestRow;++$row)
        {
            $procesandoNombre=false;
            for ($col = 0; $col <$highestColumnIndex;++$col)
            {
                $value=$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
                if ($col==0 && substr($value,0,1)=="&" && substr($value,3,1)=="&"){
                    $specRow=true;
                    if(substr($value,0,4)=="&ta&"){
                        $specRowType='T';
                        $value=substr($value, 4);
                    }elseif(substr($value,0,4)=="&co&"){
                        $specRowType='C';
                        $value=substr($value, 4);
                    }else{
                        $specRowType='';
                    }

                }elseif($col==0 && substr($value,0,1)!="&"){
                    $specRow=false;
                    $specRowType='';
                }
                if($specRow===true){
                    if($specRowType=='C'&&is_null($this->setColumnaSpecs)){
                        $valorArray=explode(':',$value);
                        if(isset($valorArray[1])){
                            if($valorArray[0]=='nombre'){
                                $this->validCols[]=$valorArray[1];
                                if(preg_match("/-/i", $valorArray[1])){
                                    $nombres=explode('-',$valorArray[1]);
                                }else{
                                    $nombres=array($valorArray[1]);
                                }
                                foreach($nombres as $nombre):
                                    $this->columnaSpecs[$nombre]['nombre']=$nombre;
                                    $this->tablaSpecs['columnas'][]=$nombre;
                                    $this->tablaSpecs['columnasProceso'][]=$nombre;
                                endforeach;
                                $procesandoNombre=true;
                            }elseif($procesandoNombre===true){
                                $this->validCols[]='noProcess';
                            }elseif($procesandoNombre!==true&&!empty($this->validCols)&&isset($this->validCols[$col])&&$this->validCols[$col]!='noProcess'){
                                if(preg_match("/-/i", $this->validCols[$col])){
                                    $nombres=explode('-',$this->validCols[$col]);
                                }else{
                                    $nombres=array($this->validCols[$col]);
                                }
                                foreach($nombres as $nombre):
                                    $this->columnaSpecs[$nombre][$valorArray[0]]=$valorArray[1];
                                endforeach;
                            }
                            if($valorArray[0]=='llave'&&$valorArray[1]=='si'&&isset($this->validCols[$col])&&$this->validCols[$col]!='noProcess'){
                                if(preg_match("/-/i", $this->validCols[$col])){
                                    $nombres=explode('-',$this->validCols[$col]);
                                }else{
                                    $nombres=array($this->validCols[$col]);
                                }
                                foreach($nombres as $nombre):
                                    $this->tablaSpecs['llaves'][]=$this->columnaSpecs[$nombre]['nombre'];
                                endforeach;
                            }
                            if($valorArray[0]=='proceso'&&$valorArray[1]=='no'&&isset($this->validCols[$col])&&$this->validCols[$col]!='noProcess'){
                                $encontrado=array_search($this->columnaSpecs[$this->validCols[$col]]['nombre'], $this->tablaSpecs['columnasProceso'],true);
                                if($encontrado!==false){
                                    unset($this->tablaSpecs['columnasProceso'][$encontrado]);
                                }
                            }
                        }
                    }
                    if($specRowType=='T'&&is_null($this->setTablaSpecs)){
                        $valorArray=explode(':',$value);
                        if(isset($valorArray[1])){
                            $this->tablaSpecs[$valorArray[0]]=$valorArray[1];
                        }
                    }
                }else{
                    if(!empty($this->validCols)&&isset($this->validCols[$col])&&$this->validCols[$col]!='noProcess'){
                        $columnName=$this->validCols[$col];
                        if(preg_match("/-/i", $this->validCols[$col])){
                            $value=explode('-',$value);
                            $columnName=explode('-',$columnName);
                        }else{
                            $value=array($value);
                            $columnName=array($columnName);
                        }
                        foreach($value as $key => $parteValor):
                            if(isset($this->columnaSpecs[$columnName[$key]]['tipo'])&&$this->columnaSpecs[$columnName[$key]]['tipo']=='exceldate'){
                                $parteValor = date('d/m/Y', mktime(0,0,0,1,$parteValor-1,1900));
                            }
                            if(isset($this->columnaSpecs[$columnName[$key]]['tipo'])&&$this->columnaSpecs[$columnName[$key]]['tipo']=='file'&& $key==1){
                                $parteValor = str_pad($parteValor,10, 0, STR_PAD_LEFT);
                            }
                            $existentesRaw[$fila][$this->columnaSpecs[$columnName[$key]]['nombre']]=$parteValor;
                        endforeach;
                    }else{
                        $existentesDescartados[$fila][]=$value;
                    }
                }
            }
            $fila ++;

        }

        if(empty($existentesRaw)){
            $this->setMensajes('No hay valores que procesar');
            return false;
        }

        foreach ($existentesRaw as $nroLinea=>$valor):
            $indice=array();
            foreach($this->tablaSpecs['llaves'] as $llave):
                $indice[]=$valor[$llave];
                unset($valor[$llave]);

            endforeach;
            $existentesIndizados[implode('|',$indice)]=$valor;
            $existentesIndizadosMulti[implode('|',$indice)][]=$valor;
            if(!empty($this->getCamposCustom())){
                $i=0;
                foreach($this->getCamposCustom() as $llaveCustom):
                    if(isset($valor[$llaveCustom])){
                        $existentesCustomIndizadosMulti[implode('|',$indice)][$i][$llaveCustom]=$valor[$llaveCustom];
                        $existentesCustomIndizados[implode('|',$indice)][$llaveCustom]=$valor[$llaveCustom];

                    }
                    $i++;
                endforeach;
            }
            if(!empty($this->getCamposCustom())){
                foreach($this->getCamposCustom() as $llaveCustom):
                    if(isset($valor[$llaveCustom])){
                        $existentesCustomRaw[$nroLinea][$llaveCustom]=$valor[$llaveCustom];
                    }
                endforeach;
            }
        endforeach;

        $this->setExistentesRaw($existentesRaw);
        $this->setExistentesIndizados($existentesIndizados);
        $this->setExistentesIndizadosMulti($existentesIndizadosMulti);
        if(!empty($existentesCustomIndizados)){
            $this->setExistentesCustomIndizados($existentesCustomIndizados);
        }

        if(!empty($existentesCustomIndizadosMulti)){
            $this->setExistentesCustomIndizadosMulti($existentesCustomIndizadosMulti);
        }
        if(!empty($existentesCustomRaw)){
            $this->setExistentesCustomRaw($existentesCustomRaw);
        }
        if(!empty($existentesDescartados)){
            $this->setExistentesDescartados($existentesDescartados);
        }
        return true;
    }

    public function escribirExcel($archivo,$encabezados,$datos,$dateColumns=array(),$tipo='xlsx'){
        $excelLoader = $this->container->get('phpexcel');
        $phpExcelObject = $excelLoader->createPHPExcelObject();
        $phpExcelObject->getProperties()->setCreator("Viapac")
            ->setTitle("Documento Generado")
            ->setDescription("Documento generado para descargar");
        $hoja=$phpExcelObject->setActiveSheetIndex(0);
        foreach($encabezados as $key=>$encabezado):
            $columna = $excelLoader->stringFromColumnIndex($key);
            $hoja->setCellValue($columna.'1', $encabezado);
        endforeach;
        $hoja->fromArray($datos, NULL, 'A2');
        if(isset($dateColumns)){
            $highestRow = $hoja->getHighestRow();
            foreach($dateColumns as $column):
                $hoja->getStyle($column.'2:'.$column.$highestRow)
                    ->getNumberFormat()
                    ->setFormatCode('d/mm/yy');
            endforeach;
        }
        $phpExcelObject->getActiveSheet()->setTitle('Hoja de datos');
        $phpExcelObject->setActiveSheetIndex(0);
        $writer = $this->container->get('phpexcel')->createWriter($phpExcelObject, 'Excel2007');
        $response = $this->container->get('phpexcel')->createStreamedResponse($writer);
        $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename='.$this->container->get('gopro_dbproceso_comun_variable')->sanitizeString($archivo).'.'.$tipo);
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        return $response;
    }

    public function validarArchivo($repositorio,$archivoEjecutar,$funcionArchivo){
        $ejecutar=false;
        if($archivoEjecutar!==null){
            $archivoAlmacenado=$repositorio->find($archivoEjecutar);
            $ejecutar=true;
        }
        if($ejecutar===true&&(empty($archivoAlmacenado)||(!empty($archivoAlmacenado)&&$archivoAlmacenado->getOperacion()!=$funcionArchivo))){
            $this->setMensajes('El archivo no existe, o no es valido para el proceso');
            $ejecutar=false;
        }elseif($ejecutar===true){
            $this->archivoValido=$archivoAlmacenado;
        }
        return $ejecutar;
    }
}