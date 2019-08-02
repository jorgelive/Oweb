<?php

namespace Gopro\TransporteBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class ServicioAdminController extends CRUDController
{

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

        $this->admin->create($newObject);

        $this->addFlash('sonata_flash_success', 'Servicio clonado correctamente');

        return new RedirectResponse($this->admin->generateUrl('list'));

    }

}
