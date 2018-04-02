<?php

namespace Gopro\CuentaBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;

class MovimientoAdmin extends AbstractAdmin
{
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('periodo')
            ->add('fechahora')
            ->add('descripcion', null, [
                'label' => 'Descripción'
            ])
            ->add('clase', null, [
                'label' => 'Clase'
            ])
            ->add('centro', null, [
                'label' => 'Centro de costo'
            ])
            ->add('debe', null, [
                'label' => 'Ingreso'
            ])
            ->add('haber', null, [
                'label' => 'Egreso'
            ])
            ->add('cobradorpagador', null, [
                'label' => 'Cobrador / Pagador'
            ])
            ->add('user', null, [
                'label' => 'Encargado'
            ])
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('periodo')
            ->add('fechahora')
            ->add('descripcion', null, [
                'label' => 'Descripción'
            ])
            ->add('clase', null, [
                'label' => 'Clase'
            ])
            ->add('centro', null, [
                'label' => 'Centro de costo'
            ])
            ->add('debe', null, [
                'label' => 'Ingreso'
            ])
            ->add('haber', null, [
                'label' => 'Egreso'
            ])
            ->add('cobradorpagador', null, [
                'label' => 'Cobrador / Pagador'
            ])
            ->add('user', null, [
                'label' => 'Encargado'
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
            ->add('fechahora', DateTimePickerType::class, [
                'label' => 'Fecha',
                'dp_use_current' => true,
                'dp_show_today' => true,
                'format'=> 'yyyy/MM/dd HH:mm'
            ])
            ->add('clase', null, [
                'label' => 'Clase'
            ])
            ->add('centro', null, [
                'label' => 'Centro de costo'
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
            ->add('cobradorpagador', null, [
                'label' => 'Cobrador / Pagador'
            ])
            ->add('user', null, [
                'label' => 'Encargado'
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('periodo')
            ->add('fechahora')
            ->add('descripcion', null, [
                'label' => 'Descripción'
            ])
            ->add('clase', null, [
                'label' => 'Clase'
            ])
            ->add('centro', null, [
                'label' => 'Centro de costo'
            ])
            ->add('debe', null, [
                'label' => 'Ingreso'
            ])
            ->add('haber', null, [
                'label' => 'Egreso'
            ])
            ->add('cobradorpagador', null, [
                'label' => 'Cobrador / Pagador'
            ])
            ->add('user', null, [
                'label' => 'Encargado'
            ])
        ;
    }
}
