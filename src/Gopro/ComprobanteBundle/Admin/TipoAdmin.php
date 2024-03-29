<?php

namespace Gopro\ComprobanteBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class TipoAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('nombre')
            ->add('codigo', null, [
                'label' => 'Código'
            ])
            ->add('codigoexterno', null, [
                'label' => 'Código externo'
            ])
            ->add('serie')
            ->add('correlativo')
            ->add('esnotacredito', null, [
                'label' => 'Nota de crédito?'
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
            ->add('nombre')
            ->add('codigo', null, [
                'label' => 'Código'
            ])
            ->add('codigoexterno', null, [
                'label' => 'Código externo'
            ])
            ->add('serie')
            ->add('correlativo')
            ->add('esnotacredito', null, [
                'label' => 'Nota de crédito?'
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
            ->add('codigo', null, [
                'label' => 'Código'
            ])
            ->add('codigoexterno', null, [
                'label' => 'Código externo'
            ])
            ->add('serie')
            ->add('correlativo')
            ->add('esnotacredito', null, [
                'label' => 'Nota de crédito?'
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
            ->add('codigo', null, [
                'label' => 'Código'
            ])
            ->add('codigoexterno', null, [
                'label' => 'Código externo'
            ])
            ->add('serie')
            ->add('correlativo')
            ->add('esnotacredito', null, [
                'label' => 'Nota de crédito?'
            ])
        ;
    }

}
