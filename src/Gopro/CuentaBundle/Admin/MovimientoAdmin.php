<?php

namespace Gopro\CuentaBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\DatePickerType;

class MovimientoAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('periodo')
            ->add('fecha')
            ->add('descripcion', null, [
                'label' => 'Descripción'
            ])
            ->add('clase', null, [
                'label' => 'Clase'
            ])
            ->add('debe', null, [
                'label' => 'Ingreso'
            ])
            ->add('haber', null, [
                'label' => 'Egreso'
            ])
            ->add('user', null, [
                'label' => 'Encargado'
            ])
            ->add('centro', null, [
                'label' => 'Centro de costo'
            ])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('periodo')
            ->add('fecha')
            ->add('descripcion', null, [
                'label' => 'Descripción'
            ])
            ->add('clase', null, [
                'label' => 'Clase'
            ])
            ->add('debe', null, [
                'label' => 'Ingreso'
            ])
            ->add('haber', null, [
                'label' => 'Egreso'
            ])
            ->add('user', null, [
                'label' => 'Encargado'
            ])
            ->add('centro', null, [
                'label' => 'Centro de costo'
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
        if ($this->getRoot()->getClass() != 'Gopro\CuentaBundle\Entity\Cuenta'
        && $this->getRoot()->getClass() != 'Gopro\CuentaBundle\Entity\Periodo'){
            $formMapper->add('periodo');
        }

        $formMapper
            ->add('fecha', DatePickerType::class, [
                'label' => 'Fecha',
                'dp_use_current' => true,
                'dp_show_today' => true,
                'format'=> 'yyyy/MM/dd'
            ])
            ->add('clase', null, [
                'label' => 'Clase'
            ])
            ->add('descripcion', null, [
                'label' => 'Descripción'
            ])
            ->add('debe', null, [
                'label' => 'Ingreso'
            ])
            ->add('haber', null, [
                'label' => 'Egreso'
            ])
            ->add('user', null, [
                'label' => 'Encargado'
            ])
            ->add('centro', null, [
                'label' => 'Centro de costo'
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('periodo')
            ->add('fecha')
            ->add('descripcion', null, [
                'label' => 'Descripción'
            ])
            ->add('clase', null, [
                'label' => 'Clase'
            ])
            ->add('debe', null, [
                'label' => 'Ingreso'
            ])
            ->add('haber', null, [
                'label' => 'Egreso'
            ])
            ->add('user', null, [
                'label' => 'Encargado'
            ])
            ->add('centro', null, [
                'label' => 'Centro de costo'
            ])
        ;
    }
}
