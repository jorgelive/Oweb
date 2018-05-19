<?php

namespace Gopro\ComprobanteBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class ComprobanteAdmin extends AbstractAdmin
{

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('dependencia', null, [
                'label' => 'Cliente',
            ])
            ->add('serviciocontables.servicio.nombre', null, [
                'label' => 'Servicio'
            ])
            ->add('serviciocontables.servicio.fechahorainicio', 'doctrine_orm_callback',[
                'label' => 'Fecha de servicio',
                'callback' => function($queryBuilder, $alias, $field, $value) {

                    if (!$value['value'] || !($value['value'] instanceof \DateTime)) {
                        return;
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

                    return;

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
            ->add('estado', null, [
                'label' => 'Estado'
            ])
            ->add('tipo', null, [
                'label' => 'Tipo'
            ])
            ->add('nota', null, [
                'label' => 'Nota'
            ])
            ->add('moneda')
            ->add('documento')
            ->add('fechaemision', 'doctrine_orm_callback',[
                'label' => 'Fecha de emisión',
                'callback' => function($queryBuilder, $alias, $field, $value) {

                    if (!$value['value'] || !($value['value'] instanceof \DateTime)) {
                        return;
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

                    return;

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
            ->add('original')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('serviciocontables', null, [
                'label' => 'Items Transporte',
            ])
            ->add('comprobanteitems', null, [
                'label' => 'Items',
            ])
            ->add('nota')
            ->add('dependencia', null, [
                'label' => 'Cliente',
            ])
            ->add('estado', null, [
                'label' => 'Estado',
                'route' => ['name' => 'show']
            ])
            ->add('tipo', null, [
                'label' => 'Tipo',
                'route' => ['name' => 'show']
            ])
            ->add('moneda', null, [
                'route' => ['name' => 'show']
            ])
            ->add('total')
            ->add('serie')
            ->add('documento', null, [
                'template' => 'GoproComprobanteBundle:ComprobanteAdmin:list_documento.html.twig'
            ])
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
                        'template' => 'GoproComprobanteBundle:ComprobanteAdmin:list__action_emitir.html.twig'
                    ]
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
            ->add('dependencia')
            ->add('estado', null, [
                'label' => 'Estado'
            ])
            ->add('tipo', null, [
                'label' => 'Tipo'
            ])
            ->add('nota', null, [
                'label' => 'Nota'
            ])
            ->add('moneda')
            ->add('neto')
            ->add('impuesto')
            ->add('total')
            ->add('original')
            ->add('seriedocumento', TextType::class, [
                'label' => 'Documento',
                'disabled' => true,
                'required' => false
            ])
            ->add('comprobanteitems', CollectionType::class, [
                'by_reference' => false,
                'label' => 'Items'
            ], [
                'edit' => 'inline',
                'inline' => 'table'
            ])
            ->add('serviciocontables', CollectionType::class, [
                'by_reference' => false,
                'label' => 'Items transporte'
            ], [
                'edit' => 'inline',
                'inline' => 'table'
            ])
        ;

        $widthModifier = function (FormInterface $form) {

            $form
                ->add('nota', null, [
                    'label' => 'Nota',
                    'attr' => [
                        'style' => 'width: 200px;'
                    ]
                ])
                ->add('neto', null, [
                    'label' => 'Neto',
                    'attr' => [
                        'style' => 'width: 80px; text-align: right;'
                    ]
                ])
                ->add('impuesto', null, [
                    'label' => 'Impuesto',
                    'attr' => [
                        'style' => 'width: 80px; text-align: right;'
                    ]
                ])
                ->add('total', null, [
                    'label' => 'Total',
                    'attr' => [
                        'style' => 'width: 80px; text-align: right;'
                    ]
                ])
            ;
        };

        $formBuilder = $formMapper->getFormBuilder();
        $formBuilder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($widthModifier) {
                if($event->getData()
                    && $this->getRoot()->getClass() == 'Gopro\TransporteBundle\Entity\Servicio'
                ){
                    $widthModifier($event->getForm());
                }
            }
        );
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('dependencia', null, [
                'label' => 'Cliente',
            ])
            ->add('comprobanteitems', null, [
                'label' => 'Items',
            ])
            ->add('serviciocontables', null, [
                'label' => 'Items Transporte',
            ])
            ->add('estado', null, [
                'label' => 'Estado',
                'route' => ['name' => 'show']
            ])
            ->add('tipo', null, [
                'label' => 'Tipo',
                'route' => ['name' => 'show']
            ])
            ->add('nota', null, [
                'label' => 'Nota'
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
        $collection->add('emitir', $this->getRouterIdParameter() . '/emitir');
    }

}
