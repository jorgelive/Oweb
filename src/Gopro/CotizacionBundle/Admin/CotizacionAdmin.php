<?php

namespace Gopro\CotizacionBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class CotizacionAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('nombre')
            ->add('numeropasajeros', null, [
                'label' => 'Cantidad de pasajeros'
            ])
            ->add('comision', null, [
                'label' => 'Comisión'
            ])
            ->add('file')
            ->add('estadocotizacion', null, [
                'label' => 'Estado'
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
            ->add('numeropasajeros', null, [
                'label' => 'Cantidad de pasajeros'
            ])
            ->add('comision', null, [
                'label' => 'Comisión'
            ])
            ->add('file')
            ->add('estadocotizacion', null, [
                'label' => 'Estado'
            ])
            ->add('_action', null, [
                'label' => 'Acciones',
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                    'resumen' => [
                        'template' => 'GoproCotizacionBundle:CotizacionAdmin:list__action_resumen.html.twig'
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

        if ($this->getRoot()->getClass() != 'Gopro\CotizacionBundle\Entity\File'){
            $formMapper->add('file');
        }
        $formMapper
            ->add('nombre')
            ->add('numeropasajeros', null, [
                'label' => 'Cantidad de pasajeros'
            ])
            ->add('comision', null, [
                'label' => 'Comisión'
            ])
            ->add('estadocotizacion', null, [
                'label' => 'Estado'
            ])
            ->add('cotservicios', 'sonata_type_collection', [
                'by_reference' => false,
                'label' => 'Servicios'
            ], [
                'edit' => 'inline',
                'inline' => 'table'
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
            ->add('numeropasajeros', null, [
                'label' => 'Cantidad de pasajeros'
            ])
            ->add('comision', null, [
                'label' => 'Comisión'
            ])
            ->add('file')
            ->add('estadocotizacion', null, [
                'label' => 'Estado'
            ])

        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('resumen', $this->getRouterIdParameter() . '/resumen');
    }
}
