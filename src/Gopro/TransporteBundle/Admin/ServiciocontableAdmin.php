<?php

namespace Gopro\TransporteBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class ServiciocontableAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('estadocontable', null, [
                'label' => 'Estado'
            ])
            ->add('tiposercontable', null, [
                'label' => 'Tipo'
            ])
            ->add('descripcion', null, [
                'label' => 'Descripción'
            ])
            ->add('moneda')
            ->add('neto')
            ->add('impuesto')
            ->add('total')
            ->add('serie')
            ->add('documento')
            ->add('fechaemision', null, [
                'label' => 'Fecha emisión'
            ])
            ->add('url')
            ->add('original')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('servicio', null, [
                'route' => ['name' => 'show']
            ])
            ->add('servicio.fecha', null, [
                'label' => 'Fecha servicio'
            ])
            ->add('estadocontable', null, [
                'label' => 'Estado',
                'route' => ['name' => 'show']
            ])
            ->add('tiposercontable', null, [
                'label' => 'Tipo',
                'route' => ['name' => 'show']
            ])
            ->add('moneda', null, [
                'route' => ['name' => 'show']
            ])
            ->add('total')
            ->add('serie')
            ->add('documento')
            ->add('fechaemision', null, [
                'label' => 'Fecha emisión'
            ])
            ->add('original')
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                    'facturar' => [
                        'template' => 'GoproTransporteBundle:ServiciocontableAdmin:list__action_facturar.html.twig'
                    ]
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
            ->add('estadocontable', null, [
                'label' => 'Estado'
            ])
            ->add('tiposercontable', null, [
                'label' => 'Tipo'
            ])
            ->add('descripcion', null, [
                'label' => 'Descripción'
            ])
            ->add('moneda')
            ->add('neto')
            ->add('impuesto')
            ->add('total')
            ->add('original')
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('servicio', null, [
                'route' => ['name' => 'show']
            ])
            ->add('servicio.id', null, [
                'label' => 'Identificador de servicio',
            ])
            ->add('servicio.fecha', null, [
                'label' => 'Fecha servicio',
                'route' => ['name' => 'show']
            ])
            ->add('estadocontable', null, [
                'label' => 'Estado',
                'route' => ['name' => 'show']
            ])
            ->add('tiposercontable', null, [
                'label' => 'Tipo',
                'route' => ['name' => 'show']
            ])
            ->add('descripcion', null, [
                'label' => 'Descripción'
            ])
            ->add('moneda', null, [
                'route' => ['name' => 'show']
            ])
            ->add('neto')
            ->add('impuesto')
            ->add('total')
            ->add('serie')
            ->add('documento')
            ->add('fechaemision', null, [
                'label' => 'Fecha emisión'
            ])
            ->add('url')
            ->add('original')
            ->add('sercontablemensajes', null, [
                'label' => 'Mensajes'
            ])
        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('facturar', $this->getRouterIdParameter() . '/facturar');
    }

}
