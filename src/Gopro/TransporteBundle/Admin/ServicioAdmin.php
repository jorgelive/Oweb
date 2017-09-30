<?php

namespace Gopro\TransporteBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ServicioAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('fecha')
            ->add('dependencia.organizacion', null, [
                'route' => ['name' => 'show']
            ])
            ->add('unidad')
            ->add('conductor')
            ->add('nombre')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('fecha')
            ->add('hora')
            ->add('dependencia.organizacion', null, [
                'route' => ['name' => 'show'],
                'label' => 'Cliente'
            ])
            ->add('unidad', null, [
                'associated_property' => 'abreviatura',
                'route' => ['name' => 'show']
            ])
            ->add('conductor', null, [
                'route' => ['name' => 'show']
            ])
            ->add('nombre')
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
            ->add('dependencia', null, [
                'property' => 'organizaciondependencia'
            ])
            ->add('hora')
            ->add('fecha')
            ->add('unidad')
            ->add('conductor')
            ->add('nombre')
            ->add('serviciooperativos', 'sonata_type_collection',[
                'by_reference' => false,
                'label' => 'Operativo'
            ], [
                'edit' => 'inline',
                'inline' => 'table',
            ])
            ->add('serviciofiles', 'sonata_type_collection', [
                'by_reference' => false,
                'label' => 'Files'
            ], [
                'edit' => 'inline',
                'inline' => 'table'
            ])
            ->add('serviciocontables', 'sonata_type_collection', [
                'by_reference' => false,
                'label' => 'Facturación'
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
            ->add('dependencia.organizacion', null, [
                'route' => ['name' => 'show']
            ])
            ->add('hora')
            ->add('fecha')
            ->add('unidad', null, [
                'route' => ['name' => 'show']
            ])
            ->add('conductor', null, [
                'route' => ['name' => 'show']
            ])
            ->add('nombre')
            ->end()
            ->with('Informacion Operativa')
            ->add('serviciooperativos', 'collection', [
                'template' => 'GoproTransporteBundle:ServicioAdmin:show_serviciooperativo_collection.html.twig'
            ])
            ->end()
            ->with('Files')
            ->add('serviciofiles', 'collection', [
                'template' => 'GoproTransporteBundle:ServicioAdmin:show_serviciofile_collection.html.twig'
            ])
            ->end()
        ;
    }

}
