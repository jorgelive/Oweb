<?php

namespace Gopro\TransporteBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ConductorAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('user', null, [
                'label'=>'Nombre',
            ])
            ->add('licencia')
            ->add('abreviatura')
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
            ->add('user.fullname', null, [
                'label'=>'Nombre'
            ])
            ->add('licencia')
            ->add('abreviatura')
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
            ->add('user', null, [
                'required' => true,
                'choice_label' => 'fullname',
                'label' => 'Nombre'
            ])
            ->add('licencia')
            ->add('abreviatura')
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
            ->add('user.fullname', null, [
                'label'=>'Nombre'
            ])
            ->add('user.phone', null, [
                'label' => 'Teléfono'
            ])
            ->add('licencia')
            ->add('abreviatura')
            ->add('color')
        ;
    }

}
