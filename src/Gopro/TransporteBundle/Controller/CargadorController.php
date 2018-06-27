<?php
namespace Gopro\TransporteBundle\Controller;
use Gopro\ComprobanteBundle\Entity\Comprobante;
use Gopro\MainBundle\Form\ArchivocamposType;
use Gopro\MainBundle\Entity\Archivo;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Gopro\TransporteBundle\Entity\Servicio;
use Gopro\TransporteBundle\Entity\Serviciooperativo;
use Gopro\TransporteBundle\Entity\Serviciocomponente;
use Gopro\TransporteBundle\Entity\Serviciocontable;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Cargador controller.
 *
 * @Route("/cargador")
 */
class CargadorController extends Controller
{

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
        $columnaspecs[] = array('nombre' => 'dependencia');
        $columnaspecs[] = array('nombre' => 'tipoComprobante');
        $columnaspecs[] = array('nombre' => 'notaComprobante');
        $columnaspecs[] = array('nombre' => 'monedaComprobante');
        $columnaspecs[] = array('nombre' => 'totalContable');
        $columnaspecs[] = array('nombre' => 'descripcionContable');
        $columnaspecs[] = array('nombre' => 'fechainicioServicio', 'tipo' => 'exceldate');
        $columnaspecs[] = array('nombre' => 'horainicioServicio', 'tipo' => 'exceltime');
        $columnaspecs[] = array('nombre' => 'horafinServicio', 'tipo' => 'exceltime');
        $columnaspecs[] = array('nombre' => 'fechafinServicio', 'tipo' => 'exceldate');
        $columnaspecs[] = array('nombre' => 'nombreServicio');
        $columnaspecs[] = array('nombre' => 'unidadServicio');
        $columnaspecs[] = array('nombre' => 'conductorServicio');
        $columnaspecs[] = array('nombre' => 'transferOperativo');
        $columnaspecs[] = array('nombre' => 'guideOperativo');
        $columnaspecs[] = array('nombre' => 'notaOperativo');
        $columnaspecs[] = array('nombre' => 'horaComponente', 'tipo' => 'exceltime');
        $columnaspecs[] = array('nombre' => 'nombreComponente');
        $columnaspecs[] = array('nombre' => 'codigoComponente');
        $columnaspecs[] = array('nombre' => 'numadlComponente');
        $columnaspecs[] = array('nombre' => 'numchdComponente');
        $columnaspecs[] = array('nombre' => 'origenComponente');
        $columnaspecs[] = array('nombre' => 'destinoComponente');
        $columnaspecs[] = array('nombre' => 'notaComponente');



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

           if(isset($linea['dependencia']) && !empty(isset($linea['dependencia']))) {
                if(!isset($i)){
                    $i = 0;
                }else{
                    $i++;
                }

                unset($j);

                if(
                    !isset($linea['monedaComprobante'])
                    || empty($linea['monedaComprobante'])
                    || !isset($linea['tipoComprobante'])
                    || empty($linea['tipoComprobante'])

                ) {
                    $variables->setMensajes('La linea ' . $linea['excelRowNumber'] . ' tiene los datos del tipo o la moneda de comprobante incompletos.', 'error');
                    $variables->setMensajes('No se ha ejecutado la carga.', 'error');
                    return array('formulario' => $formulario->createView(), 'archivosAlmacenados' => $archivosAlmacenados, 'mensajes' => $variables->getMensajes());
                }

                if(isset($linea['notaComprobante']) && !empty($linea['notaComprobante'])){
                   $preproceso[$i]['notaComprobante'] = $linea['notaComprobante'];
                }

                $preproceso[$i]['tipoComprobante'] = (integer)$linea['tipoComprobante'];
                $preproceso[$i]['monedaComprobante'] = (integer)$linea['monedaComprobante'];
                $preproceso[$i]['estadoComprobante'] = 1;
                if($preproceso[$i]['tipoComprobante'] < 0){
                    $preproceso[$i]['estadoComprobante'] = 3;
                }

                $preproceso[$i]['dependencia'] = (integer)$linea['dependencia'];

            }

            if(isset($linea['fechainicioServicio'])){
                if(
                    !isset($linea['horainicioServicio'])
                    || empty($linea['horainicioServicio'])
                    || !isset($linea['fechafinServicio'])
                    || empty($linea['fechafinServicio'])
                    || !isset($linea['horafinServicio'])
                    || empty($linea['fechafinServicio'])
                ) {
                    $variables->setMensajes('La linea ' . $linea['excelRowNumber'] . ' tiene los datos del servicio incompletos.', 'error');
                    $variables->setMensajes('No se ha ejecutado la carga.', 'error');
                    return array('formulario' => $formulario->createView(), 'archivosAlmacenados' => $archivosAlmacenados, 'mensajes' => $variables->getMensajes());
                }

                if(
                    !isset($linea['totalContable'])
                    || empty($linea['totalContable'])
                    || !isset($linea['descripcionContable'])
                    || empty($linea['descripcionContable'])
                ) {
                    $variables->setMensajes('La linea ' . $linea['excelRowNumber'] . ' tiene los datos contables incompletos.', 'error');
                    $variables->setMensajes('No se ha ejecutado la carga.', 'error');
                    return array('formulario' => $formulario->createView(), 'archivosAlmacenados' => $archivosAlmacenados, 'mensajes' => $variables->getMensajes());
                }

                if(!isset($j)){
                    $j = 0;
                }else {
                    $j++;
                }

                unset ($k);

                //servicio
                $preproceso[$i]['servicio'][$j]['fechahorainicio'] = \DateTime::createFromFormat('Y-m-d H:i:s', $linea['fechainicioServicio'] . ' ' . $linea['horainicioServicio']);
                if (!isset($linea['fechafinServicio']) || empty($linea['fechafinServicio'])) {
                    $linea['fechafinServicio'] = $linea['fechainicioServicio'];
                }
                if (!isset($linea['horafinServicio']) || empty($linea['horafinServicio'])) {
                    $linea['horafinServicio'] = date('H:i:s', strtotime($linea['horainicioServicio']) + 60 * 60);
                }
                $preproceso[$i]['servicio'][$j]['fechahorafin'] = \DateTime::createFromFormat('Y-m-d H:i:s', $linea['fechafinServicio'] . ' ' . $linea['horafinServicio']);
                $preproceso[$i]['servicio'][$j]['nombre'] = $linea['nombreServicio'];
                if (isset($linea['unidadServicio'])) {
                    $preproceso[$i]['servicio'][$j]['unidad'] = (integer)$linea['unidadServicio'];
                }
                if (isset($linea['conductorServicio'])) {
                    $preproceso[$i]['servicio'][$j]['conductor'] = (integer)$linea['conductorServicio'];
                }

                //contable

                $preproceso[$i]['servicio'][$j]['servicioContable']['total'] = $linea['totalContable'];
                $preproceso[$i]['servicio'][$j]['servicioContable']['descripcion'] = $linea['descripcionContable'];

                if($preproceso[$i]['estadoComprobante'] == 3){
                    if(!isset($preproceso[$i]['total'])){
                        $preproceso[$i]['total'] = 0;
                    }

                    $preproceso[$i]['total'] += $linea['totalContable'];
                }

                if (isset($linea['transferOperativo'])) {
                    $preproceso[$i]['servicio'][$j]['servicioOperativo']['transfer'] = $linea['transferOperativo'];
                }

                if (isset($linea['guideOperativo'])) {
                    $preproceso[$i]['servicio'][$j]['servicioOperativo']['guide'] = $linea['guideOperativo'];
                }

                if (isset($linea['notaOperativo'])) {
                    $preproceso[$i]['servicio'][$j]['servicioOperativo']['nota'] = $linea['notaOperativo'];
                }


            }

            if(!isset($k)){
                $k = 0;
            }else {
                $k++;
            }

            if(
                !isset($linea['horaComponente'])
                || empty($linea['horaComponente'])
                || !isset($linea['nombreComponente'])
                || empty($linea['nombreComponente'])
                || !isset($linea['codigoComponente'])
                || empty($linea['codigoComponente'])
                || !isset($linea['numadlComponente'])
                || empty($linea['numadlComponente'])
            ) {
                $variables->setMensajes('La linea ' . $linea['excelRowNumber'] . ' tiene los datos del componente incompletos.', 'error');
                $variables->setMensajes('No se ha ejecutado la carga.', 'error');
                return array('formulario' => $formulario->createView(), 'archivosAlmacenados' => $archivosAlmacenados, 'mensajes' => $variables->getMensajes());
            }

            $preproceso[$i]['servicio'][$j]['serviciocomponente'][$k]['hora'] = $linea['horaComponente'];
            $preproceso[$i]['servicio'][$j]['serviciocomponente'][$k]['nombre'] = $linea['nombreComponente'];
            $preproceso[$i]['servicio'][$j]['serviciocomponente'][$k]['codigo'] = $linea['codigoComponente'];
            $preproceso[$i]['servicio'][$j]['serviciocomponente'][$k]['numadl'] = (integer)$linea['numadlComponente'];

            if (isset($linea['numchdComponente'])) {
                $preproceso[$i]['servicio'][$j]['serviciocomponente'][$k]['numchd'] = (integer)$linea['numchdComponente'];
            }

            $preproceso[$i]['servicio'][$j]['serviciocomponente'][$k]['origen'] = $linea['origenComponente'];
            $preproceso[$i]['servicio'][$j]['serviciocomponente'][$k]['destino'] = $linea['destinoComponente'];

            if (isset($linea['notaComponente'])) {
                $preproceso[$i]['servicio'][$j]['serviciocomponente'][$k]['nota'] = $linea['notaComponente'];
            }

        endforeach;

        if (empty($preproceso)) {
            $variables->setMensajes('No se preproceso ningun elemento', 'error');
            $variables->setMensajes('No se ha ejecutado la carga.', 'error');
            return array('formulario' => $formulario->createView(), 'archivosAlmacenados' => $archivosAlmacenados, 'mensajes' => $variables->getMensajes());
        }

        $this->cargarBaseDeDatos ($preproceso);

        return array('formulario' => $formulario->createView(), 'archivosAlmacenados' => $archivosAlmacenados, 'mensajes' => $variables->getMensajes());

    }

    private function cargarBaseDeDatos ($preproceso){

        $variables = $this->get('gopro_main.variableproceso');
        $em = $this->getDoctrine()->getManager();
        $cargar = true;
        foreach ($preproceso as $com):

            $comprobante = new Comprobante();

            $comprobante->setDependencia($em->getReference('Gopro\UserBundle\Entity\Dependencia', $com['dependencia']));
            $comprobante->setEstado($em->getReference('Gopro\ComprobanteBundle\Entity\Estado', $com['estadoComprobante']));
            $comprobante->setMoneda($em->getReference('Gopro\MaestroBundle\Entity\Moneda', $com['monedaComprobante']));
            $comprobante->setTipo($em->getReference('Gopro\ComprobanteBundle\Entity\Tipo', $com['tipoComprobante']));
            if (isset($com['notaComprobante'])) {
                $comprobante->setNota($com['notaComprobante']);
            }

            if (isset($com['servicio']) && count($com['servicio']) > 0) {

                foreach ($com['servicio'] as $serv):
                    $servicio = new Servicio();

                    $servicio->setDependencia($em->getReference('Gopro\UserBundle\Entity\Dependencia', $com['dependencia']));
                    $servicio->setFechahorainicio($serv['fechahorainicio']);
                    $servicio->setFechahorafin($serv['fechahorafin']);
                    $servicio->setNombre($serv['nombre']);
                    if (isset($serv['unidad'])) {
                        $servicio->setUnidad($em->getReference('Gopro\TransporteBundle\Entity\Unidad', $serv['unidad']));
                    }
                    if (isset($serv['conductor'])) {
                        $servicio->setConductor($em->getReference('Gopro\TransporteBundle\Entity\Conductor', $serv['conductor']));
                    }

                    $servicioContable = new Serviciocontable();
                    $servicioContable->setTotal($serv['servicioContable']['total']);
                    $servicioContable->setDescripcion($serv['servicioContable']['descripcion']);
                    $servicioContable->setComprobante($comprobante);
                    $servicio->addServiciocontable($servicioContable);

                    if (isset($serv['serviciocomponente']) && count($serv['serviciocomponente']) > 0) {
                        foreach ($serv['serviciocomponente'] as $serviciocomponente) {
                            $serviciocomponenteEntity = new Serviciocomponente();
                            $serviciocomponenteEntity->setHora(\DateTime::createFromFormat('H:i:s', $serviciocomponente['hora']));
                            $serviciocomponenteEntity->setNombre($serviciocomponente['nombre']);
                            $serviciocomponenteEntity->setCodigo($serviciocomponente['codigo']);
                            $serviciocomponenteEntity->setNumadl($serviciocomponente['numadl']);
                            if (isset($serviciocomponente['numchd'])) {
                                $serviciocomponenteEntity->setNumchd($serviciocomponente['numchd']);
                            }
                            $serviciocomponenteEntity->setOrigen($serviciocomponente['origen']);
                            $serviciocomponenteEntity->setDestino($serviciocomponente['destino']);
                            if (isset($serviciocomponente['nota'])) {
                                $serviciocomponenteEntity->setNota($serviciocomponente['nota']);
                            }
                            $servicio->addServiciocomponente($serviciocomponenteEntity);
                        }
                    } else {
                        $variables->setMensajes('No existen componentes en el servicio.', 'error');
                        $cargar = false;
                    }

                    if (isset($serv['servicioOperativo']['transfer'])) {
                        $servicioOperativoTransfer = new Serviciooperativo();
                        $servicioOperativoTransfer->setTiposeroperativo($em->getReference('Gopro\TransporteBundle\Entity\Tiposeroperativo', 1));
                        $servicioOperativoTransfer->setTexto($serv['servicioOperativo']['transfer']);
                        $servicio->addServiciooperativo($servicioOperativoTransfer);
                    }

                    if (isset($serv['servicioOperativo']['guide'])) {
                        $servicioOperativoGuide = new Serviciooperativo();
                        $servicioOperativoGuide->setTiposeroperativo($em->getReference('Gopro\TransporteBundle\Entity\Tiposeroperativo', 2));
                        $servicioOperativoGuide->setTexto($serv['servicioOperativo']['guide']);
                        $servicio->addServiciooperativo($servicioOperativoGuide);
                    }

                    if (isset($serv['servicioOperativo']['nota'])) {
                        $servicioOperativoNota = new Serviciooperativo();
                        $servicioOperativoNota->setTiposeroperativo($em->getReference('Gopro\TransporteBundle\Entity\Tiposeroperativo', 3));
                        $servicioOperativoNota->setTexto($serv['servicioOperativo']['nota']);
                        $servicio->addServiciooperativo($servicioOperativoNota);
                    }

                    $em->persist($comprobante);
                    $em->persist($servicio);

                endforeach;

            }else{
                $variables->setMensajes('No existen servicios en el comprobante.', 'error');
                $cargar = false;
            }



        endforeach;

        if ($cargar === true){
            $em->flush();
            $variables->setMensajes('Se ha ejecutado la carga.', 'success');
            return true;
        }else{
            $variables->setMensajes('No se ha ejecutado la carga.', 'error');
            return false;
        }

    }

}