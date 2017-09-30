<?php

namespace Gopro\UserBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CuentaAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('user.dependencia', null, [
                'label' => 'Dependencia'
            ])
            ->add('user.area', null, [
                'label' => 'Area'
            ])
            ->add('user', null, [
                'label' => 'Usuario'
            ])
            ->add('cuentatipo', null, [
                'label' => 'Tipo de cuenta'
            ])
            ->add('nombre', null, [
                'label' => 'Nombre'
            ])
            ->add('password',null, [
                'label' => 'Contraseña'
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
            ->add('user.dependencia', null, [
                'label' => 'Dependencia'
            ])
            ->add('user.area', null, [
                'label' => 'Area'
            ])
            ->add('user', null, [
                'label' => 'Usuario'
            ])
            ->add('cuentatipo', null, [
                'label' => 'Tipo de cuenta'])
            ->add('nombre', null, [
                'editable' => true
            ])
            ->add('password', null, [
                'editable' => true,
                'label' => 'Contraseña'
            ])
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ]
            ])
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('user', null, [
                'label' => 'Usuario'
            ])
            ->add('cuentatipo', null, [
                'label' => 'Contraseña'
            ])
            ->add('nombre')
            ->add('password', null, [
                'label' => 'Contraseña'
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
            ->add('user.dependencia', null, [
                'label' => 'Dependencia'
            ])
            ->add('user.area', null, [
                'label' => 'Area'
            ])
            ->add('user', null, [
                'label' => 'Usuario'
            ])
            ->add('cuentatipo', null, [
                'label' => 'Tipo de cuenta'
            ])
            ->add('nombre')
            ->add('password', null, [
                'label' => 'Contraseña'
            ])
        ;
    }
}
