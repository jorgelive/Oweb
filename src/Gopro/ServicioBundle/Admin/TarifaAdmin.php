<?php

namespace Gopro\ServicioBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Sonata\TranslationBundle\Filter\TranslationFieldFilter;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class TarifaAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('componente')
            ->add('nombre')
            ->add('titulo', TranslationFieldFilter::class, [
                'label' => 'Título'
            ])
            ->add('moneda')
            ->add('monto')
            ->add('validezinicio', null, [
                'label' => 'Inicio'
            ])
            ->add('validezfin', null, [
                'label' => 'Fin'
            ])
            ->add('prorrateado')
            ->add('tipopax', null, [
                'label' => 'Tipo de paaajero'
            ])
            ->add('tipotarifa', null, [
                'label' => 'Típo de tarifa'
            ])
            ->add('capacidadmin', null, [
                'label' => 'Cantidad min'
            ])
            ->add('capacidadmax', null, [
                'label' => 'Cantidad max'
            ])
            ->add('edadmin', null, [
                'label' => 'Edad min'
            ])
            ->add('edadmax', null, [
                'label' => 'Edad max'
            ])
            ->add('categoriatour', null, [
                'label' => 'Categoria de tour'
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
            ->add('componente')
            ->add('nombre')
            ->add('titulo', null, [
                'label' => 'Título'
            ])
            ->add('moneda')
            ->add('monto')
            ->add('validezinicio', null, [
                'label' => 'Inicio'
            ])
            ->add('validezfin', null, [
                'label' => 'Fin'
            ])
            ->add('prorrateado')
            ->add('tipopax', null, [
                'label' => 'Tipo de pasajero'
            ])
            ->add('tipotarifa', null, [
                'label' => 'Tipo de tarifa'
            ])
            ->add('capacidadmin', null, [
                'label' => 'Cantidad min'
            ])
            ->add('capacidadmax', null, [
                'label' => 'Cantidad max'
            ])
            ->add('edadmin', null, [
                'label' => 'Edad min'
            ])
            ->add('edadmax', null, [
                'label' => 'Edad max'
            ])
            ->add('categoriatour', null, [
                'label' => 'Categoria de tour'
            ])
            ->add('_action', null, [
                'label' => 'Acciones',
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ])
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        if ($this->getRoot()->getClass() != 'Gopro\ServicioBundle\Entity\Servicio'
            && $this->getRoot()->getClass() != 'Gopro\ServicioBundle\Entity\Componente'
        ){
            $formMapper->add('componente');
        }

        $formMapper
            ->add('nombre')
            ->add('titulo', null, [
                'label' => 'Título'
            ])
            ->add('moneda')
            ->add('monto')
            ->add('prorrateado')
            ->add('tipotarifa', null, [
                'label' => 'Tipo de tarifa'
            ])
            ->add('tipopax', null, [
                'label' => 'Tipo de pasajero'
            ])
            ->add('capacidadmin', null, [
                'label' => 'Cantidad min'
            ])
            ->add('capacidadmax', null, [
                'label' => 'Cantidad max'
            ])
            ->add('edadmin', null, [
                'label' => 'Edad min'
            ])
            ->add('edadmax', null, [
                'label' => 'Edad max'
            ])
            ->add('validezinicio', DatePickerType::class, [
                'label' => 'Inicio',
                'dp_use_current' => true,
                'dp_show_today' => true,
                'format'=> 'yyyy/MM/dd',
                'attr' => [
                    'class' => 'fecha'
                ]
            ])
            ->add('validezfin', DatePickerType::class, [
                'label' => 'Fin',
                'dp_use_current' => true,
                'dp_show_today' => true,
                'format'=> 'yyyy/MM/dd',
                'attr' => [
                    'class' => 'fecha'
                ]
            ])
            ->add('categoriatour', null, [
                'label' => 'Categoria de tour'
            ])
        ;

        $widthModifier = function (FormInterface $form) {

            $form
                ->add('nombre', null, [
                    'label' => 'Nombre',
                    'attr' => [
                        'style' => 'width: 200px;'
                    ]
                ])
                ->add('titulo', null, [
                    'label' => 'Título',
                    'attr' => [
                        'style' => 'width: 200px;'
                    ]
                ])
                ->add('monto', null, [
                    'label' => 'Monto',
                    'attr' => [
                        'style' => 'width: 80px; text-align: right;'
                    ]
                ])
                ->add('capacidadmin', null, [
                    'label' => 'Cantidad min',
                    'attr' => [
                        'style' => 'width: 80px; text-align: right;'
                    ]
                ])
                ->add('capacidadmax', null, [
                    'label' => 'Cantidad max',
                    'attr' => [
                        'style' => 'width: 80px; text-align: right;'
                    ]
                ])
                ->add('edadmin', null, [
                    'label' => 'Edad min',
                    'attr' => [
                        'style' => 'width: 80px; text-align: right;'
                    ]
                ])
                ->add('edadmax', null, [
                    'label' => 'Edad max',
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
                    && $this->getRoot()->getClass() == 'Gopro\ServicioBundle\Entity\Componente'
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
            ->add('componente')
            ->add('nombre')
            ->add('titulo', null, [
                'label' => 'Título'
            ])
            ->add('moneda')
            ->add('monto')
            ->add('validezinicio', null, [
                'label' => 'Inicio'
            ])
            ->add('validezfin', null, [
                'label' => 'Fin'
            ])
            ->add('prorrateado')
            ->add('tipopax', null, [
                'label' => 'Típo de pasajero'
            ])
            ->add('tipotarifa', null, [
                'label' => 'Tipo de tarifa'
            ])
            ->add('capacidadmin', null, [
                'label' => 'Cantidad min'
            ])
            ->add('capacidadmax', null, [
                'label' => 'Cantidad max'
            ])
            ->add('edadmin', null, [
                'label' => 'Edad min'
            ])
            ->add('edadmax', null, [
                'label' => 'Edad max'
            ])

            ->add('categoriatour', null, [
                'label' => 'Categoria de tour'
            ])
        ;
    }
}
