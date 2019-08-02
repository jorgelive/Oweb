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

    public function clonarAction($id = null, Request $request = null)
    {

        $id = $request->get($this->admin->getIdParameter());

        $object = $this->admin->getObject($id);

        $em = $this->getDoctrine()->getManager();

        if (!$object) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id: %s', $id));
        }

        $this->admin->checkAccess('edit', $object);

        $newObject = clone $object;

        $newObject->setNombre($object->getNombre().' (Clone)');

        $newObject->setEstadocotizacion($em->getReference('Gopro\CotizacionBundle\Entity\Estadocotizacion', 1));

        foreach ($newObject->getCotservicios() as $cotservicio):
            foreach ($cotservicio->getCotcomponentes() as $cotcomponente):
                $cotcomponente->setEstadocotcomponente($em->getReference('Gopro\CotizacionBundle\Entity\Estadocotcomponente', 1));
            endforeach;
        endforeach;

        $this->admin->create($newObject);

        $this->addFlash('sonata_flash_success', 'Cotización clonada correctamente');

        return new RedirectResponse($this->admin->generateUrl('list'));

    }

    public function showAction($id = null, Request $request = null)
    {

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

        if($this->container->get('gopro_cotizacion.resumen')->setTl($request->get('tl'))->procesar($object->getId())){
            return $this->renderWithExtraParams('GoproCotizacionBundle:CotizacionAdmin:show.html.twig',
                ['cotizacion' => $this->container->get('gopro_cotizacion.resumen')->getDatosCotizacion(),
                    'tabs' => $this->container->get('gopro_cotizacion.resumen')->getDatosTabs(),
                    'object' => $object,
                    'action' => 'show',
                    'elements' => $this->admin->getShow()

                ], null);
        }else{
            $this->addFlash('sonata_flash_error', $this->container->get('gopro_cotizacion.resumen')->getMensaje());
            return new RedirectResponse($this->admin->generateUrl('list'));
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

        if($this->container->get('gopro_cotizacion.resumen')->setTl($request->get('tl'))->procesar($object->getId())){
            return $this->renderWithExtraParams('GoproCotizacionBundle:CotizacionAdmin:resumen.html.twig',
                ['cotizacion' => $this->container->get('gopro_cotizacion.resumen')->getDatosCotizacion(),
                    'tabs' => $this->container->get('gopro_cotizacion.resumen')->getDatosTabs(),
                    'object' => $object,
                    'action' => 'resumen',
                    'elements' => $this->admin->getShow(),

                ], null);
        }else{
            $this->addFlash('sonata_flash_error', $this->container->get('gopro_cotizacion.resumen')->getMensaje());
            return new RedirectResponse($this->admin->generateUrl('list'));
        }
    }
}
