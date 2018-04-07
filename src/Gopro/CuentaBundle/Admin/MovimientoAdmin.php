<?php

namespace Gopro\CuentaBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MovimientoAdmin extends AbstractAdmin
{
    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'fechahora',
    ];

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('periodo')
            ->add('fechahora', 'doctrine_orm_callback',[
                'label' => 'Fecha',
                'callback' => function($queryBuilder, $alias, $field, $value) {

                    if (!$value['value'] || !($value['value'] instanceof \DateTime)) {
                        return false;
                    }
                    $fechaMasUno = clone ($value['value']);
                    $fechaMasUno->add(new \DateInterval('P1D'));

                    if(empty($value['type'])){
                        $queryBuilder->andWhere("DATE($alias.$field) >= :fechahora");
                        $queryBuilder->andWhere("DATE($alias.$field) < :fechahoraMasUno");
                        $queryBuilder->setParameter('fechahora', $value['value']);
                        $queryBuilder->setParameter('fechahoraMasUno', $fechaMasUno);
                        return true;
                    } elseif($value['type'] == 1){
                        $queryBuilder->andWhere("DATE($alias.$field) >= :fechahora");
                        $queryBuilder->setParameter('fechahora', $value['value']);
                        return true;
                    } elseif($value['type'] == 2){
                        $queryBuilder->andWhere("DATE($alias.$field) < :fechahoraMasUno");
                        $queryBuilder->setParameter('fechahoraMasUno', $fechaMasUno);
                        return true;
                    } elseif($value['type'] == 3){
                        $queryBuilder->andWhere("DATE($alias.$field) >= :fechahoraMasUno");
                        $queryBuilder->setParameter('fechahoraMasUno', $fechaMasUno);
                        return true;
                    } elseif($value['type'] == 4){
                        $queryBuilder->andWhere("DATE($alias.$field) < :fechahora");
                        $queryBuilder->setParameter('fechahora', $value['value']);
                        return true;
                    }
                    return true;

                },
                'field_type' => DatePickerType::class,
                'field_options' => [
                    'dp_use_current' => true,
                    'dp_show_today' => true,
                    'format'=> 'yyyy/MM/dd'
                ],
                'operator_type' => ChoiceType::class,
                'operator_options' => array(
                    'choices' => array(
                        'Igual a' => 0,
                        'Mayor o igual a' => 1,
                        'Menor o igual a' => 2,
                        'Mayor a' => 3,
                        'Menor a' => 4
                    )
                )
            ])
            ->add('descripcion', null, [
                'label' => 'Descripción'
            ])
            ->add('periodotransferencia', null, [
                'label' => 'Trans O / D'
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
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('periodo')
            ->add('fechahora',  null, [
                'label' => 'Fecha',
                'format' => 'Y/m/d H:i'
            ])
            ->add('descripcion', null, [
                'label' => 'Descripción'
            ])
            ->add('periodotransferencia', null, [
                'label' => 'Trans O / D'
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
            ->add('periodotransferencia', null, [
                'label' => 'Trans O / D'
            ])
            ->add('debe', null, [
                'label' => 'Ingreso',
                'attr' => ['class' => 'ingresoinput']
            ])
            ->add('haber', null, [
                'label' => 'Egreso',
                'attr' => ['class' => 'egresoinput']
            ])
            ->add('cobradorpagador', null, [
                'label' => 'Cobrador / Pagador'
            ])
        ;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('periodo')
            ->add('fechahora',  null, [
                'label' => 'Fecha',
                'format' => 'Y/m/d H:i'
            ])
            ->add('descripcion', null, [
                'label' => 'Descripción'
            ])
            ->add('periodotransferencia', null, [
                'label' => 'Trans O / D'
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
        ;
    }
}
