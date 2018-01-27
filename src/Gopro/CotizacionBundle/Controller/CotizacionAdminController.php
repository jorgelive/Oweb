<?php

namespace Gopro\CotizacionBundle\Controller;


use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;



class CotizacionAdminController extends CRUDController
{

    var $clasificacionTarifas = [];
    var $resumenClasificado = [];

    public function showAction($id = null, Request $request = null)
    {

        $request = $this->getRequest();
        $id = $request->get($this->admin->getIdParameter());

        $object = $this->admin->getObject($id);

        if (!$object) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
        }

        $this->admin->checkAccess('show', $object);

        $preResponse = $this->preShow($request, $object);
        if (null !== $preResponse) {
            return $preResponse;
        }

        $this->admin->setSubject($object);


        if($this->container->get('gopro_cotizacion.resumen')->procesar($object->getId())){
            return $this->renderWithExtraParams('GoproCotizacionBundle:CotizacionAdmin:show.html.twig',
                ['cotizacion' => $this->container->get('gopro_cotizacion.resumen')->getDatosCotizacion(),
                    'tabs' => $this->container->get('gopro_cotizacion.resumen')->getDatosTabs(),
                    'object' => $object,
                    'action' => 'resumen',
                    'elements' => $this->admin->getShow()

                ], null);
        }else{
            throw new NotFoundHttpException($this->container->get('gopro_cotizacion.resumen')->getMensaje());
        }

    }

    function resumenAction($id = null, Request $request = null)
    {

        $request = $this->getRequest();
        $id = $request->get($this->admin->getIdParameter());

        $object = $this->admin->getObject($id);

        if (!$object) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
        }

        //$this->admin->checkAccess('show', $object);

        $preResponse = $this->preShow($request, $object);
        if (null !== $preResponse) {
            return $preResponse;
        }

        $this->admin->setSubject($object);

        if($this->container->get('gopro_cotizacion.resumen')->procesar($object->getId())){
            return $this->renderWithExtraParams('GoproCotizacionBundle:CotizacionAdmin:resumen.html.twig',
                ['cotizacion' => $this->container->get('gopro_cotizacion.resumen')->getDatosCotizacion(),
                    'tabs' => $this->container->get('gopro_cotizacion.resumen')->getDatosTabs(),
                    'object' => $object,
                    'action' => 'resumen',
                    'elements' => $this->admin->getShow(),

                ], null);
        }else{
            throw new NotFoundHttpException($this->container->get('gopro_cotizacion.resumen')->getMensaje());
        }
    }
}
