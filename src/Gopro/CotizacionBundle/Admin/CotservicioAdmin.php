<?php

namespace Gopro\CotizacionBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Form\Type\ModelAutocompleteType;

use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class CotservicioAdmin extends AbstractAdmin
{

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('fechahorainicio', null, [
                'label' => 'Inicio'
            ])
            ->add('servicio')
            ->add('fechahorafin', null, [
                'label' => 'Fin'
            ])
            ->add('cotizacion', null, [
                'label' => 'Cotización'
            ])
            ->add('itinerario')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('fechahorainicio', null, [
                'label' => 'Inicio',
                'format' => 'Y/m/d H:i'
            ])
            ->add('servicio')
            ->add('fechahorafin', null, [
                'label' => 'Inicio',
                'format' => 'Y/m/d H:i'
            ])
            ->add('cotizacion', null, [
                'label' => 'Cotización'
            ])
            ->add('itinerario')
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

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        if ($this->getRoot()->getClass() != 'Gopro\CotizacionBundle\Entity\File'
            && $this->getRoot()->getClass() != 'Gopro\CotizacionBundle\Entity\Cotizacion'
        ){
            $formMapper->add('cotizacion');
        }

        $formMapper
            ->add('servicio', ModelAutocompleteType::class, [
                'property' => 'nombre',
                'route' => ['name' => 'gopro_servicio_servicio_alldropdown', 'parameters' => []],
                'placeholder' => '',
                'minimum_input_length' => 0,
                'dropdown_auto_width' => false
            ])
            ->add('itinerario', ModelAutocompleteType::class, [
                'property' => 'nombre',
                'template' => 'GoproCotizacionBundle:Form:ajax_dropdown_type.html.twig',
                'route' => ['name' => 'gopro_servicio_itinerario_porserviciodropdown', 'parameters' => []],
                'placeholder' => '',
                'context' => '/\[itinerario\]$/g, "[servicio]"',
                'minimum_input_length' => 0,
                'dropdown_auto_width' => false
            ])
            ->add('fechahorainicio', DateTimePickerType::class, [
                'label' => 'Inicio',
                'dp_show_today' => true,
                'format'=> 'yyyy/MM/dd HH:mm',
                'attr' => [
                    'class' => 'fechahora serviciofechainicio'
                ]
            ])
            ->add('fechahorafin', DateTimePickerType::class, [
                'label' => 'Fin',
                'dp_show_today' => true,
                'format'=> 'yyyy/MM/dd HH:mm',
                'attr' => [
                    'class' => 'fechahora serviciofechafin'
                ]
            ])
            ->add('cotcomponentes', CollectionType::class, [
                'by_reference' => false,
                'label' => 'Componentes'
            ], [
                'edit' => 'inline',
                'inline' => 'table'
            ])
        ;

        $horarioModifier = function (FormInterface $form, $duracion, $paraleloclass) {

            $form->add('fechahorainicio', DateTimePickerType::class, [
                    'label' => 'Inicio',
                    'dp_show_today' => true,
                    'format'=> 'yyyy/MM/dd HH:mm',
                    'attr' => [
                        'duracion' => $duracion,
                        'class' => 'fechahora serviciofechainicio' . $paraleloclass
                    ]
                ])
                ->add('fechahorafin', DateTimePickerType::class, [
                    'label' => 'Fin',
                    'dp_show_today' => true,
                    'format'=> 'yyyy/MM/dd HH:mm',
                    'attr' => [
                        'duracion' => $duracion,
                        'class' => 'fechahora serviciofechafin'
                    ]
                ])
            ;
        };

        $formBuilder = $formMapper->getFormBuilder();
        $formBuilder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($horarioModifier) {
                $paraleloClass = '';
                if($event->getData()
                    && $event->getData()->getServicio()
                    && $event->getData()->getServicio()->getParalelo()
                ){
                    $paraleloClass = ' paralelo';
                }

                if($event->getData()
                    && $event->getData()->getItinerario()
                ){
                    $horarioModifier($event->getForm(), $event->getData()->getItinerario()->getDuracion(), $paraleloClass);
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
            ->add('fechahorainicio', null, [
                'label' => 'Inicio',
                'format' => 'Y/m/d H:i'
            ])
            ->add('servicio')
            ->add('fechahorafin', null, [
                'label' => 'Inicio',
                'format' => 'Y/m/d H:i'
            ])
            ->add('cotizacion')
            ->add('itinerario')
        ;
    }

}
