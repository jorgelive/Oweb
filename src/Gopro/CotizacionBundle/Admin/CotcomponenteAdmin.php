<?php

namespace Gopro\CotizacionBundle\Admin;

use Gopro\ServicioBundle\Entity\Servicio;
use Gopro\ServicioBundle\Repository\ComponenteRepository;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;
use Sonata\AdminBundle\Show\ShowMapper;

use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class CotcomponenteAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('cotservicio', null, [
                'label' => 'Servicio'
            ])
            ->add('componente')
            ->add('cantidad')
            ->add('fechahorainicio', null, [
                'label' => 'Inicio',
                'format' => 'Y/m/d H:i'
            ])
            ->add('fechahorafin', null, [
                'label' => 'Inicio',
                'format' => 'Y/m/d H:i'
            ])
            ->add('estadocotcomponente', null, [
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
            ->add('cotservicio', null, [
                'label' => 'Servicio'
            ])
            ->add('componente')
            ->add('cantidad')
            ->add('fechahorainicio', null, [
                'label' => 'Inicio',
                'format' => 'Y/m/d H:i'
            ])
            ->add('fechahorafin', null, [
                'label' => 'Inicio',
                'format' => 'Y/m/d H:i'
            ])
            ->add('estadocotcomponente', null, [
                'label' => 'Estado'
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
        if ($this->getRoot()->getClass() != 'Gopro\CotizacionBundle\Entity\File'
            && $this->getRoot()->getClass() != 'Gopro\CotizacionBundle\Entity\Cotizacion'
            && $this->getRoot()->getClass() != 'Gopro\CotizacionBundle\Entity\Cotservicio'
        ){
            $formMapper->add('cotservicio', null, [
                'label' => 'Servicio'
            ]);
        }

        $formMapper
            ->add('componente', ModelAutocompleteType::class, [
                'property' => 'nombre',
                'template' => 'GoproCotizacionBundle:Form:ajax_dropdown_type.html.twig',
                'route' => ['name' => 'gopro_servicio_componente_porserviciodropdown', 'parameters' => []],
                'placeholder' => '',
                'context' => '/\[cotcomponentes\]\[\d\]\[componente\]$/g, "[servicio]"',
                'minimum_input_length' => 0,
                'dropdown_auto_width' => false
            ])
            ->add('cantidad', null, [
                    'required' => false,
                    'attr' => ['class' => 'readonly']
                ]
            )
            ->add('fechahorainicio', DateTimePickerType::class, [
                'label' => 'Inicio',
                'dp_show_today' => true,
                'format'=> 'yyyy/MM/dd HH:mm',
                'attr' => [
                    'class' => 'fechahora componenteinicio',
                    'horariodependiente' => false
                ]
            ])
            ->add('fechahorafin', DateTimePickerType::class, [
                'label' => 'Fin',
                'dp_show_today' => true,
                'format'=> 'yyyy/MM/dd HH:mm',
                'attr' => [
                    'class' => 'fechahora componentefin',
                    'horariodependiente' => false
                ]
            ])
            ->add('estadocotcomponente', null, [
                'label' => 'Estado'
            ])
            ->add('cottarifas', CollectionType::class , [
                'by_reference' => false,
                'label' => 'Tarifas'
            ], [
                'edit' => 'inline',
                'inline' => 'table'
            ])
        ;

        $cantidadModifier = function (FormInterface $form) {

            $form->add(
                'cantidad',
                null,
                [
                    'label' => 'Cantidad',
                    'required' => false,
                    'attr' => ['class' => 'dependeduracion readonly']
                ]
            );
        };

        $horarioModifier = function (FormInterface $form, $duracion, $horarioDependiente) {

            $form->add('fechahorainicio', DateTimePickerType::class, [
                    'label' => 'Inicio',
                    'dp_show_today' => true,
                    'format'=> 'yyyy/MM/dd HH:mm',
                    'attr' => [
                        'duracion' => $duracion,
                        'horariodependiente' => $horarioDependiente,
                        'class' => 'fechahora componenteinicio'
                    ]
                ])
                ->add('fechahorafin', DateTimePickerType::class, [
                    'label' => 'Fin',
                    'dp_show_today' => true,
                    'format'=> 'yyyy/MM/dd HH:mm',
                    'attr' => [
                        'duracion' => $duracion,
                        'horariodependiente' => $horarioDependiente,
                        'class' => 'fechahora componentefin'
                    ]
                ])
            ;
        };

        $formBuilder = $formMapper->getFormBuilder();
        $formBuilder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($cantidadModifier, $horarioModifier) {

                if($event->getData()
                    && $event->getData()->getComponente()
                    && $event->getData()->getComponente()->getTipocomponente()
                    && $event->getData()->getComponente()->getTipocomponente()->getDependeduracion() === true
                ){
                    $cantidadModifier($event->getForm());
                }

                $horarioDependiente = false;
                $duracion = 0;
                if($event->getData()
                    && $event->getData()->getComponente()
                    && !is_null($event->getData()->getComponente()->getDuracion())
                ) {
                    $duracion = $event->getData()->getComponente()->getDuracion();
                }elseif ($event->getData()
                    && $event->getData()->getCotservicio()
                    && $event->getData()->getCotservicio()->getItinerario()
                    && $event->getData()->getCotservicio()->getItinerario()->getDuracion())
                {
                    $duracion = $event->getData()->getCotservicio()->getItinerario()->getDuracion();
                    $horarioDependiente = true;
                }
                //var_dump($event->getData()->getComponente()->getTipocomponente()->getDependeduracion());
                if(!empty($duracion)){
                    $horarioModifier($event->getForm(), $duracion, $horarioDependiente);
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
            ->add('cotservicio')
            ->add('componente')
            ->add('cantidad')
            ->add('fechahorainicio', null, [
                'label' => 'Inicio',
                'format' => 'Y/m/d H:i'
            ])
            ->add('fechahorafin', null, [
                'label' => 'Inicio',
                'format' => 'Y/m/d H:i'
            ])
            ->add('estadocotcomponente', null, [
                'label' => 'Estado'
            ])
        ;
    }
}
