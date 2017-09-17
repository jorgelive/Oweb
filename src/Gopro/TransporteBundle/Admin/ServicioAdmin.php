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
            ->add('dependencia')
            ->add('unidad')
            ->add('conductor')
            ->add('nombre')
            ->add('hora')
            ->add('fecha')

        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('dependencia')
            ->add('unidad')
            ->add('conductor')
            ->add('nombre')
            ->add('hora')
            ->add('fecha')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('dependencia')
            ->add('unidad')
            ->add('conductor')
            ->add('nombre')
            ->add('hora')
            ->add('fecha')
            ->add('serviciooperativos', 'sonata_type_collection', array('by_reference' => false),array(
                    'edit' => 'inline',
                    'inline' => 'table'
                )
            )
            ->add('servicioreferencias', 'sonata_type_collection', array('by_reference' => false),array(
                    'edit' => 'inline',
                    'inline' => 'table'
                )
            )
            ->add('serviciocontables', 'sonata_type_collection', array('by_reference' => false),array(
                    'edit' => 'inline',
                    'inline' => 'table'
                )
            )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('dependencia')
            ->add('unidad')
            ->add('conductor')
            ->add('nombre')
            ->add('hora')
            ->add('fecha')
        ;
    }

}
