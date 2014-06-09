<?php

namespace Gopro\Vipac\DbprocesoBundle\Controller;

use Gopro\Vipac\MainBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Gopro\Vipac\DbprocesoBundle\Entity\Archivo;
use Gopro\Vipac\DbprocesoBundle\Form\ArchivoType;

/**
 * Archivo controller.
 *
 * @Route("/archivo")
 */
class ArchivoController extends BaseController
{

    /**
     * Lists all Archivo entities.
     *
     * @Route("/", name="archivo")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('GoproVipacDbprocesoBundle:Archivo')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Archivo entity.
     *
     * @Route("/", name="archivo_create")
     * @Method("POST")
     * @Template("GoproVipacDbprocesoBundle:Archivo:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Archivo();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('archivo_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
    * Creates a form to create a Archivo entity.
    *
    * @param Archivo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Archivo $entity)
    {
        $form = $this->createForm(new ArchivoType(), $entity, array(
            'action' => $this->generateUrl('archivo_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Archivo entity.
     *
     * @Route("/new", name="archivo_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Archivo();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Archivo entity.
     *
     * @Route("/{id}", name="archivo_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GoproVipacDbprocesoBundle:Archivo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Archivo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Archivo entity.
     *
     * @Route("/{id}/edit", name="archivo_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GoproVipacDbprocesoBundle:Archivo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Archivo entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
    * Creates a form to edit a Archivo entity.
    *
    * @param Archivo $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Archivo $entity)
    {
        $form = $this->createForm(new ArchivoType(), $entity, array(
            'action' => $this->generateUrl('archivo_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Archivo entity.
     *
     * @Route("/{id}", name="archivo_update")
     * @Method("PUT")
     * @Template("GoproVipacDbprocesoBundle:Archivo:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GoproVipacDbprocesoBundle:Archivo')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Archivo entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('archivo_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Archivo entity.
     *
     * @Route("/{id}", name="archivo_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()||$request->isXMLHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('GoproVipacDbprocesoBundle:Archivo')->findOneBy(['id'=>$id,'usuario'=>$this->getUserName()]);

            if (!$entity&&!$request->isXMLHttpRequest()) {
                throw $this->createNotFoundException('No se encuentra el archivo o no tiene permiso sobre el.');
            }elseif(!$entity){
                return new JsonResponse(array('exito'=>'no','titulo'=>'Fallo','mensaje'=>'No existe el archivo'));
            }

            $em->remove($entity);
            $em->flush();
        }
        if ($request->isXMLHttpRequest()){
            return new JsonResponse(array('exito'=>'si','titulo'=>'Exito','mensaje'=>'Se ha eliminado el archivo'));
        }
        return $this->redirect($this->generateUrl('archivo'));
    }

    /**
     * Creates a form to delete a Archivo entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('archivo_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
