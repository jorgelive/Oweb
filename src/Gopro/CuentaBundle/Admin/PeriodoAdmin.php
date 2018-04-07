<?php

namespace Gopro\CuentaBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Sonata\CoreBundle\Form\Type\DatePickerType;

class PeriodoAdmin extends AbstractAdmin
{

    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'modificado',
    ];


    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('cuenta')
            ->add('fechainicio', null, [
                'label' => 'Inicio'
            ])
            ->add('fechafin', null, [
                'label' => 'Fin'
            ])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->addIdentifier('cuenta')
            ->add('fechainicio', null, [
                'label' => 'Inicio'
            ])
            ->add('fechafin', null, [
                'label' => 'Fin'
            ])
            ->add('modificado',  null, [
                'label' => 'Modificación',
                'format' => 'Y/m/d H:i'

            ])
            ->add('_action', null, [
                'label' => 'Acciones',
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => []
                ]
            ])
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        if ($this->getRoot()->getClass() != 'Gopro\CuentaBundle\Entity\Cuenta'){
            $formMapper->add('cuenta');
        }

        $formMapper
            ->add('fechainicio', DatePickerType::class, [
                'label' => 'Inicio',
                'dp_use_current' => true,
                'dp_show_today' => true,
                'format'=> 'yyyy/MM/dd'
            ])
            ->add('fechafin', DatePickerType::class, [
                'required' => false,
                'label' => 'Fin',
                'dp_use_current' => true,
                'dp_show_today' => true,
                'format'=> 'yyyy/MM/dd'
            ]);
        if ($this->getRoot()->getClass() != 'Gopro\CuentaBundle\Entity\Cuenta'){
            $formMapper
                ->add('movimientos', CollectionType::class, [
                    'by_reference' => false,
                    'label' => 'Movimientos'
                ], [
                    'edit' => 'inline',
                    'inline' => 'table'
                ]);
            }

        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('cuenta')
            ->add('fechainicio', null, [
                'label' => 'Inicio'
            ])
            ->add('fechafin', null, [
                'label' => 'Fin'
            ])
        ;
    }
}
