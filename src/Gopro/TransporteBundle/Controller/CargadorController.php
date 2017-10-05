<?php
namespace Gopro\TransporteBundle\Controller;
use Gopro\MainBundle\Form\ArchivocamposType;
use Gopro\MainBundle\Entity\Archivo;
use Gopro\MainBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Gopro\TransporteBundle\Entity\Servicio;
use Gopro\TransporteBundle\Entity\Serviciooperativo;
use Gopro\TransporteBundle\Entity\Serviciofile;
use Gopro\TransporteBundle\Entity\Serviciocontable;
use Gopro\MaestroBundle\Entity\Moneda;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Cargador controller.
 *
 * @Route("/cargador")
 */
class CargadorController extends Controller
{

    protected $igv = 18;

    /**
     * @Route("/genericoprograma/{archivoEjecutar}", name="gopro_transporte_cargador_genericoprograma", defaults={"archivoEjecutar" = null})
     * @Template()
     */
    public function genericoprogramaAction(Request $request, $archivoEjecutar)
    {
        $variables = $this->get('gopro_main.variableproceso');
        $operacion = 'transporte_cargador_genericoprograma';
        $repositorio = $this->getDoctrine()->getRepository('GoproMainBundle:Archivo');
        $archivosAlmacenados = $repositorio->findBy(array('user' => $this->getUser(), 'operacion' => $operacion), array('creado' => 'DESC'));
        $opciones = array('operacion' => $operacion);
        $formulario = $this->createForm(ArchivocamposType::class, $opciones, array(
            'action' => $this->generateUrl('gopro_main_archivo_create'),
        ));

        $formulario->handleRequest($request);

        if (empty($archivoEjecutar)) {
            $variables->setMensajes('Seleccione el archivo a procesar.', 'info');
            return array('formulario' => $formulario->createView(), 'archivosAlmacenados' => $archivosAlmacenados, 'mensajes' => $variables->getMensajes());
        }

        $tablaSpecs = array('filasDescartar' => 1);
        $columnaspecs[] = array('nombre' => 'dependenciaServicio');
        $columnaspecs[] = array('nombre' => 'fechaServicio', 'tipo' => 'exceldate');
        $columnaspecs[] = array('nombre' => 'horaServicio', 'tipo' => 'exceltime');
        $columnaspecs[] = array('nombre' => 'horafinServicio', 'tipo' => 'exceltime');
        $columnaspecs[] = array('nombre' => 'fechafinServicio', 'tipo' => 'exceldate');
        $columnaspecs[] = array('nombre' => 'nombreServicio');
        $columnaspecs[] = array('nombre' => 'unidadServicio');
        $columnaspecs[] = array('nombre' => 'conductorServicio');
        $columnaspecs[] = array('nombre' => 'horaFile', 'tipo' => 'exceltime');
        $columnaspecs[] = array('nombre' => 'nombreFile');
        $columnaspecs[] = array('nombre' => 'codigoFile');
        $columnaspecs[] = array('nombre' => 'numadlFile');
        $columnaspecs[] = array('nombre' => 'numchdFile');
        $columnaspecs[] = array('nombre' => 'origenFile');
        $columnaspecs[] = array('nombre' => 'destinoFile');
        $columnaspecs[] = array('nombre' => 'notaFile');
        $columnaspecs[] = array('nombre' => 'transferOperativo');
        $columnaspecs[] = array('nombre' => 'guideOperativo');
        $columnaspecs[] = array('nombre' => 'notaOperativo');
        $columnaspecs[] = array('nombre' => 'tiposercontableContable');
        $columnaspecs[] = array('nombre' => 'monedaContable');
        $columnaspecs[] = array('nombre' => 'totalContable');
        $columnaspecs[] = array('nombre' => 'descripcionContable');


        $archivoInfo = $this->get('gopro_main.archivoexcel')
            ->setArchivoBase($repositorio, $archivoEjecutar, $operacion)
            ->setArchivo()
            ->setSkipRows(1)
            ->setParametrosReader($tablaSpecs, $columnaspecs)
            ->setDescartarBlanco(true)
            ->setTrimEspacios(true);
        if (!$archivoInfo->parseExcel()) {
            $variables->setMensajes('El archivo no se puede procesar.', 'error');
            return array('formulario' => $formulario->createView(), 'archivosAlmacenados' => $archivosAlmacenados, 'mensajes' => $variables->getMensajes());
        }

        $preproceso = [];

        foreach ($archivoInfo->getExistentesRaw() as $nroLinea => $linea):

            if(!isset($j)){
                $j = 0;
            }

            if (
                (isset($linea['dependenciaServicio']) || !empty($linea['dependeciaServicio']))
                && (isset($linea['fechaServicio']) || !empty($linea['fechaServicio']))
                && (isset($linea['horaServicio']) || !empty($linea['horaServicio']))
                && (isset($linea['nombreServicio']) || !empty($linea['nombreServicio']))

            ) {
                if(!isset($i)){
                    $i = 0;
                }else{
                    $i++;
                }

                $j = 0;

                $preproceso[$i]['dependencia'] = $linea['dependenciaServicio'];
                $preproceso[$i]['fecha'] = $linea['fechaServicio'];
                $preproceso[$i]['hora'] = $linea['horaServicio'];
                if (!isset($linea['horafinServicio']) || empty($linea['horafinServicio'])) {
                     $linea['horafinServicio'] = date('H:i:s', strtotime($linea['horaServicio']) + 60 * 60);
                }
                if (!isset($linea['fechafinServicio']) || empty($linea['fechafinServicio'])) {
                    $linea['fechafinServicio'] = $linea['fechaServicio'];
                }
                $preproceso[$i]['horafin'] = $linea['horafinServicio'];
                $preproceso[$i]['fechafin'] = $linea['fechafinServicio'];
                $preproceso[$i]['nombre'] = $linea['nombreServicio'];
                if (isset($linea['unidadServicio'])) {
                    $preproceso[$i]['unidad'] = $linea['unidadServicio'];
                }
                if (isset($linea['conductorServicio'])) {
                    $preproceso[$i]['conductor'] = $linea['conductorServicio'];
                }

            } else{
                if(!isset($i)){
                    $variables->setMensajes('La linea ' . $linea['excelRowNumber'] . ' no pertenece a ningun servicio.', 'error');
                    continue;
                }
                $j++;
            }

            if (!isset($linea['horaFile']) || !isset($linea['nombreFile']) || !isset($linea['codigoFile']) || !isset($linea['numadlFile']) || !isset($linea['origenFile']) || !isset($linea['destinoFile'])){
                $variables->setMensajes('La linea ' . $linea['excelRowNumber'] . ' no tiene los datos de file completos.', 'error');
                unset($preproceso[$i]);
                continue;
            }

            if(!isset($preproceso[$i]['dependencia'])){
                $variables->setMensajes('La linea ' . $linea['excelRowNumber'] . ' no pertenece a ningun servicio.', 'error');
                continue;
            }

            $preproceso[$i]['servicioFile'][$j]['hora'] = $linea['horaFile'];
            $preproceso[$i]['servicioFile'][$j]['nombre'] = $linea['nombreFile'];
            $preproceso[$i]['servicioFile'][$j]['codigo'] = $linea['codigoFile'];
            $preproceso[$i]['servicioFile'][$j]['numadl'] = $linea['numadlFile'];

            if (isset($linea['numchdFile'])) {
                $preproceso[$i]['servicioFile'][$j]['numchd'] = $linea['numchdFile'];
            }

            $preproceso[$i]['servicioFile'][$j]['origen'] = $linea['origenFile'];
            $preproceso[$i]['servicioFile'][$j]['destino'] = $linea['destinoFile'];

            if (isset($linea['notaFile'])) {
                $preproceso[$i]['servicioFile'][$j]['nota'] = $linea['notaFile'];
            }

            if (isset($linea['transferOperativo'])) {
                $preproceso[$i]['servicioOperativo']['transfer'] = $linea['transferOperativo'];
            }

            if (isset($linea['guideOperativo'])) {
                $preproceso[$i]['servicioOperativo']['guide'] = $linea['guideOperativo'];
            }

            if (isset($linea['notaOperativo'])) {
                $preproceso[$i]['servicioOperativo']['nota'] = $linea['notaOperativo'];
            }

            if (isset($linea['tiposercontableContable'])
                && isset($linea['monedaContable'])
                && isset($linea['totalContable'])
                && isset($linea['descripcionContable'])
            ) {
                $igv = $this->igv;
                if($linea['tiposercontableContable'] <= 0){
                    $igv = 0;
                }
                $preproceso[$i]['servicioContable']['tiposercontable'] = $linea['tiposercontableContable'];
                $preproceso[$i]['servicioContable']['moneda'] = $linea['monedaContable'];
                $preproceso[$i]['servicioContable']['neto'] = round($linea['totalContable'] / (1 +  $igv / 100), 2);
                $preproceso[$i]['servicioContable']['impuesto'] = round($linea['totalContable'] - $preproceso[$i]['servicioContable']['neto'], 2) ;
                $preproceso[$i]['servicioContable']['total'] = $linea['totalContable'];
                $preproceso[$i]['servicioContable']['descripcion'] = $linea['descripcionContable'];
            }

            $preproceso[$i]['excelRowNumber'] = $linea['excelRowNumber'];

        endforeach;

        if (empty($preproceso)) {
            $variables->setMensajes('No se preproceso ningun elemento', 'error');
            return array('formulario' => $formulario->createView(), 'archivosAlmacenados' => $archivosAlmacenados, 'mensajes' => $variables->getMensajes());
        }

        $this->cargarBaseDeDatos ($preproceso);

        $variables->setMensajes('Se ha ejecutado la carga.', 'success');
        return array('formulario' => $formulario->createView(), 'archivosAlmacenados' => $archivosAlmacenados, 'mensajes' => $variables->getMensajes());

    }

    private function cargarBaseDeDatos ($preproceso){

        $em = $this->getDoctrine()->getManager();

        foreach ($preproceso as $linea):

            $servicio = new Servicio();

            $servicio->setDependencia($em->getReference('Gopro\UserBundle\Entity\Dependencia', $linea['dependencia']));
            $servicio->setFecha(\DateTime::createFromFormat('Y-m-d', $linea['fecha']));
            $servicio->setHora(\DateTime::createFromFormat('H:i:s', $linea['hora']));
            if(isset($linea['horafin'])){
                $servicio->setHorafin(\DateTime::createFromFormat('H:i:s', $linea['horafin']));
            }
            if(isset($linea['fechafin'])){
                $servicio->setFechafin(\DateTime::createFromFormat('Y-m-d', $linea['fechafin']));
            }
            $servicio->setNombre($linea['nombre']);
            if(isset($linea['unidad'])){
                $servicio->setUnidad($em->getReference('Gopro\TransporteBundle\Entity\Unidad', $linea['unidad']));
            }
            if(isset($linea['conductor'])){
                $servicio->setConductor($em->getReference('Gopro\TransporteBundle\Entity\Conductor', $linea['conductor']));
            }

            if (isset($linea['servicioFile'])){
                foreach ($linea['servicioFile'] as $servicioFile){
                    $servicioFileEntity = new Serviciofile();
                    $servicioFileEntity->setHora(\DateTime::createFromFormat('H:i:s', $servicioFile['hora']));
                    $servicioFileEntity->setNombre($servicioFile['nombre']);
                    $servicioFileEntity->setCodigo($servicioFile['codigo']);
                    $servicioFileEntity->setNumadl($servicioFile['numadl']);
                    if(isset($servicioFile['numchd'])){
                        $servicioFileEntity->setNumchd($servicioFile['numchd']);
                    }
                    $servicioFileEntity->setOrigen($servicioFile['origen']);
                    $servicioFileEntity->setDestino($servicioFile['destino']);
                    if(isset($servicioFile['nota'])){
                        $servicioFileEntity->setNota($servicioFile['nota']);
                    }
                    $servicio->addServiciofile($servicioFileEntity);
                }
            }

            if(isset($linea['servicioContable'])){
                $servicioContable = new Serviciocontable();
                $servicioContable->setEstadocontable($em->getReference('Gopro\MaestroBundle\Entity\Estadocontable', 1));
                $servicioContable->setTiposercontable($em->getReference('Gopro\TransporteBundle\Entity\Tiposercontable', $linea['servicioContable']['tiposercontable']));
                $servicioContable->setMoneda($em->getReference('Gopro\MaestroBundle\Entity\Moneda', $linea['servicioContable']['moneda']));
                $servicioContable->setNeto($linea['servicioContable']['neto']);
                $servicioContable->setImpuesto($linea['servicioContable']['impuesto']);
                $servicioContable->setTotal($linea['servicioContable']['total']);
                $servicioContable->setDescripcion($linea['servicioContable']['descripcion']);
                $servicio->addServiciocontable($servicioContable);
            }

            if(isset($linea['servicioOperativo']['transfer'])){
                $servicioOperativoTransfer = new Serviciooperativo();
                $servicioOperativoTransfer->setTiposeroperativo($em->getReference('Gopro\TransporteBundle\Entity\Tiposeroperativo', 1));
                $servicioOperativoTransfer->setTexto($linea['servicioOperativo']['transfer']);
                $servicio->addServiciooperativo($servicioOperativoTransfer);

            }

            if(isset($linea['servicioOperativo']['guide'])){
                $servicioOperativoGuide = new Serviciooperativo();
                $servicioOperativoGuide->setTiposeroperativo($em->getReference('Gopro\TransporteBundle\Entity\Tiposeroperativo', 2));
                $servicioOperativoGuide->setTexto($linea['servicioOperativo']['guide']);
                $servicio->addServiciooperativo($servicioOperativoGuide);

            }

            if(isset($linea['servicioOperativo']['nota'])){
                $servicioOperativoNota = new Serviciooperativo();
                $servicioOperativoNota->setTiposeroperativo($em->getReference('Gopro\TransporteBundle\Entity\Tiposeroperativo', 3));
                $servicioOperativoNota->setTexto($linea['servicioOperativo']['nota']);
                $servicio->addServiciooperativo($servicioOperativoNota);

            }

            $em->persist($servicio);

        endforeach;

        $em->flush();

    }

}