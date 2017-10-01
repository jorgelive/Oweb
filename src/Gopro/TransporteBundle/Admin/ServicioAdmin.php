<?php

namespace Gopro\TransporteBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\EqualType;
use Sonata\CoreBundle\Form\Type\BooleanType;

class ServicioAdmin extends AbstractAdmin
{

    protected $datagridValues = [
        '_sort_order' => 'ASC',
        '_sort_by' => 'fecha',
    ];

    public function getFilterParameters(){

        $fecha = new \DateTime();

        $this->datagridValues = array_merge(array(
            'fecha' => array (
                'value' => $fecha->format('Y/m/d')
            )
        ), $this->datagridValues);


        return parent::getFilterParameters();
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('fecha', 'doctrine_orm_datetime', [
                'field_type'=>'sonata_type_date_picker',
                'field_options'=> [
                    'dp_use_current' => true,
                    'dp_show_today' => true,
                    'format'=> 'yyyy/MM/dd'
                ]
            ])
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
            ->add('hora', 'datetime', [
                'format' => 'H:i'
            ])
            ->add('horafin', 'datetime', [
                'format' => 'H:i',
                'label' => 'Hora fin'
            ])
            ->add('fechafin',  null, [
                'label' => 'Fecha fin'
            ])
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
                'property' => 'organizaciondependencia',
                'label' => 'cliente'
            ])
            ->add('fecha', 'sonata_type_date_picker', [
                'dp_use_current' => true,
                'dp_show_today' => true,
                'format'=> 'yyyy/MM/dd'
            ])
            ->add('hora')
            ->add('horafin', null, [
                'label' => 'Hora fin'
            ])
            ->add('fechafin', 'sonata_type_date_picker', [
                'label' => 'Fecha fin',
                'dp_use_current' => true,
                'dp_show_today' => true,
                'format'=> 'yyyy/MM/dd'
            ])
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
                'route' => ['name' => 'show'],
                'label' => 'Cliente'
            ])
            ->add('fecha')
            ->add('hora', 'datetime', [
                'format' => 'H:i'
            ])
            ->add('horafin', 'datetime', [
                'label' => 'Hora fin',
                'format' => 'H:i'
            ])
            ->add('fechafin', null, [
                'label' => 'Fecha fin'
            ])
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
