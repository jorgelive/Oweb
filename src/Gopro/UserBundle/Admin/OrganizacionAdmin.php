<?php

namespace Gopro\UserBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Sonata\AdminBundle\Show\ShowMapper;

class OrganizacionAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('nombre')
            ->add('razonsocial', null, [
                'label' => 'Razón social'
            ])
            ->add('numerodocumento', null, [
                'label' => 'Número de documento'
            ])
            ->add('email', null, [
                'label' => 'E-mail'
            ])
            ->add('direccion', null, [
                'label' => 'Dirección'
            ])
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('nombre', null, [
                'editable' => true
            ])
            ->add('razonsocial', null, [
                'label' => 'Razón social',
                'editable' => true
            ])
            ->add('numerodocumento', null, [
                'label' => 'Número de documento',
                'editable' => true
            ])
            ->add('email', null, [
                'label' => 'E-mail',
                'editable' => true
            ])
            ->add('direccion', null, [
                'label' => 'Dirección',
                'editable' => true
            ])
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
                'label' => 'Acciones'
            ])
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombre')
            ->add('razonsocial', null, [
                'label' => 'Razón social'
            ])
            ->add('numerodocumento', null, [
                'label' => 'Número de documento'
            ])
            ->add('email', null, [
                'label' => 'E-mail'
            ])
            ->add('direccion', null, [
                'label' => 'Dirección'
            ])
            ->add('dependencias', CollectionType::class, [
                'by_reference' => false
            ], [
                'edit' => 'inline',
                'inline' => 'table',
            ])
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('nombre')
            ->add('razonsocial', null, [
                'label' => 'Razón social'
            ])
            ->add('numerodocumento', null, [
                'label' => 'Número de documento'
            ])
            ->add('email', null, [
                'label' => 'E-mail'
            ])
            ->add('direccion', null, [
                'label' => 'Dirección'
            ])
        ;
    }

    /*
    public function prePersist($organizacion)
    {
        $this->preUpdate($organizacion,true);
    }


    public function preUpdate($organizacion, $agregar=false)
    {
        $organizacion->setDependencias($organizacion->getDependencias());
        foreach($organizacion->getDependencias() as $dependencia){
            $dependencia->setOrganizacion($organizacion);
        }
        if($agregar===false){
            $repositorio=$this->getConfigurationPool()->getContainer()->get('doctrine')->getRepository('GoproUserBundle:Dependencia');
            $dependenciasExistentes=$repositorio->findBy(['organizacion'=>$organizacion->getId()]);

            foreach($dependenciasExistentes as $dependenciaExistente):
                if(!$organizacion->getDependencias()->contains($dependenciaExistente)){
                    $dependenciaExistente->setOrganizacion(null);
                }
            endforeach;

        }

    }

    */
}
