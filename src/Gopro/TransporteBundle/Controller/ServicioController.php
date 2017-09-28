<?php

namespace Gopro\TransporteBundle\Controller;

use Gopro\MainBundle\Controller\BaseController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Gopro\TransporteBundle\Entity\Servicio;
use Gopro\TransporteBundle\Form\ServicioType;

/**
 * Servicio controller.
 *
 * @Route("/servicio")
 */
class ServicioController extends BaseController
{

    /**
     * Lists all Servicio entities.
     *
     * @Route("/", name="gopro_transporte_servicio")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('GoproTransporteBundle:Servicio')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Servicio entity.
     *
     * @Route("/create", name="gopro_transporte_servicio_create")
     * @Method("POST")
     * @Template("GoproTransporteBundle:Servicio:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Servicio();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()||$request->isXMLHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            if ($request->isXMLHttpRequest()){
                return new JsonResponse([
                    'mensaje'=>['exito'=>'si','titulo'=>'Exito','texto'=>'la servicio se ha agregado'],
                    'servicio'=>[
                        'id'=>$entity->getId(),
                        'nombre'=>$entity->getNombre(),
                        'creado'=>$entity->getCreado(),
                        'procesarRoute'=>$this->get('router')->generate('gopro_'.$entity->getOperacion(), array('servicioEjecutar' => $entity->getId())),
                        'borrarRoute'=>$this->get('router')->generate('gopro_transporte_servicio_delete', array('id' => $entity->getId())),
                    ]
                ]);
            }
            return $this->redirect($this->generateUrl('gopro_transporte_servicio_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Servicio entity.
     *
     * @param Servicio $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Servicio $entity)
    {
        $form = $this->createForm(new ServicioType(), $entity, array(
            'action' => $this->generateUrl('gopro_transporte_servicio_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear'));

        return $form;
    }

    /**
     * Displays a form to create a new Servicio entity.
     *
     * @Route("/new", name="gopro_transporte_servicio_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Servicio();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Servicio entity.
     *
     * @Route("/{id}", name="gopro_transporte_servicio_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GoproTransporteBundle:Servicio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se encuentra o no tiene permiso sobre la servicio.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Servicio entity.
     *
     * @Route("/{id}/edit", name="gopro_transporte_servicio_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GoproTransporteBundle:Servicio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se encuentra o no tiene permiso sobre el servicio.');
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
     * Creates a form to edit a Servicio entity.
     *
     * @param Servicio $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Servicio $entity)
    {
        $form = $this->createForm(new ServicioType(), $entity, array(
            'action' => $this->generateUrl('gopro_transporte_servicio_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar'));

        return $form;
    }

    /**
     * Edits an existing Servicio entity.
     *
     * @Route("/{id}", name="gopro_transporte_servicio_update")
     * @Method("PUT")
     * @Template("GoproTransporteBundle:Servicio:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('GoproTransporteBundle:Servicio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('No se encuentra o no tiene permiso sobre la servicio.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('gopro_transporte_servicio_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Servicio entity.
     *
     * @Route("/{id}", name="gopro_transporte_servicio_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {

        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()||$request->isXMLHttpRequest()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('GoproTransporteBundle:Servicio')->findOneBy(['id'=>$id,'user'=>$this->getUser()]);

            if(!$entity&&$request->isXMLHttpRequest()){
                return new JsonResponse(['mensaje'=>['exito'=>'no','titulo'=>'Fallo','texto'=>'No existe la servicio']]);
            }elseif (!$entity) {
                throw $this->createNotFoundException('No se encuentra o no tiene permiso sobre el servicio.');
            }

            $em->remove($entity);
            $em->flush();

            if ($request->isXMLHttpRequest()){
                return new JsonResponse(['mensaje'=>['exito'=>'si','titulo'=>'Exito','texto'=>'Se ha eliminado la servicio']]);
            }
        }
        return $this->redirect($this->generateUrl('gopro_transporte_servicio'));
    }

    /**
     * Creates a form to delete a Servicio entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->get('form.factory')->createNamedBuilder(
            'deleteForm',
            'form',
            null,
            [
                'action'=>$this->generateUrl('gopro_transporte_servicio_delete', ['id' => $id]),
                'method'=>'DELETE',
                'attr'=>['id'=>'deleteForm']
            ])
            ->add('submit', 'submit', array('label' => 'Borrar'))
            ->getForm();
    }
}
