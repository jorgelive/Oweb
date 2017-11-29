<?php

namespace Gopro\UserBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class DependenciaAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('organizacion', null, [
                'label' => 'Organización'
            ])
            ->add('nombre')
            ->add('email', null, [
                'label' => 'E-mail'
            ])
            ->add('direccion', null, [
                'label' => 'Dirección'
            ])
            ->add('color')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('organizacion', null, [
                'route' => ['name' => 'show'],
                'label' => 'Organización'
            ])
            ->add('nombre')
            ->add('email', null, [
                'label' => 'E-mail'
            ])
            ->add('direccion', null, [
                'label' => 'Dirección'
            ])
            ->add('color')
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
            ->add('organizacion', 'sonata_type_model', [
                'required' => true,
                'expanded' => true,
                'multiple' => false,
                'label' => 'Organización'
            ])
            ->add('nombre')
            ->add('email', null, [
                'label' => 'E-mail'
            ])
            ->add('direccion', null, [
                'label' => 'Dirección'
            ])
            ->add('color')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('organizacion', null, [
                'route' => ['name' => 'show'],
                'label' => 'Organización'
            ])
            ->add('nombre')
            ->add('email', null, [
                'label' => 'E-mail'
            ])
            ->add('direccion', null, [
                'label' => 'Dirección'
            ])
            ->add('color')
        ;
    }
}
