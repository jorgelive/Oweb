<?php

namespace Gopro\ComprobanteBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ProductoservicioAdmin extends AbstractAdmin
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
            ->add('codigosunat', null, [
                'label' => 'Código Sunat'
            ])
            ->add('tipoproductoservicio', null, [
                'label' => 'Tipo'
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
            ->add('codigosunat', null, [
                'label' => 'Código Sunat'
            ])
            ->add('tipoproductoservicio', null, [
                'label' => 'Tipo'
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
            ->add('codigosunat', null, [
                'label' => 'Código Sunat'
            ])
            ->add('tipoproductoservicio', null, [
                'label' => 'Tipo'
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
            ->add('codigosunat', null, [
                'label' => 'Código Sunat'
            ])
            ->add('tipoproductoservicio', null, [
                'label' => 'Tipo'
            ])
        ;
    }

}
