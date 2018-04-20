<?php

namespace Gopro\TransporteBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class ServiciofileAdmin extends AbstractAdmin
{

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('nombre')
            ->add('codigo', null, [
                'label' => 'Código'
            ])
            ->add('origen')
            ->add('destino')
            ->add('nota')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('servicio')
            ->add('hora')
            ->add('nombre')
            ->add('codigo', null, [
                'label' => 'Código'
            ])
            ->add('numadl', null, [
                'label' => 'Adultos'
            ])
            ->add('numchd', null, [
                'label' => 'Niños'
            ])
            ->add('origen')
            ->add('destino')
            ->add('nota')
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
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
        if ($this->getRoot()->getClass() != 'Gopro\TransporteBundle\Entity\Servicio'){
            $formMapper->add('servicio');
        }
        $formMapper
            ->add('hora', null, [
                'attr' => ['class' => 'horadropdown']
            ])
            ->add('nombre')
            ->add('codigo', null, [
                'label' => 'Código'
            ])
            ->add('numadl', null, [
                'label' => 'Adultos'
            ])
            ->add('numchd', null, [
                'label' => 'Niños'
            ])
            ->add('origen')
            ->add('destino')
            ->add('nota')
        ;

        $widthModifier = function (FormInterface $form) {

            $form
                ->add('nombre', null, [
                    'label' => 'Nombre',
                    'attr' => [
                        'style' => 'width: 200px;'
                    ]
                ])
                ->add('codigo', null, [
                    'label' => 'Código',
                    'attr' => [
                        'style' => 'width: 120px;'
                    ]
                ])
                ->add('numadl', null, [
                    'label' => 'Adultos',
                    'attr' => [
                        'style' => 'width: 60px; text-align: right;'
                    ]
                ])
                ->add('numchd', null, [
                    'label' => 'Niños',
                    'attr' => [
                        'style' => 'width: 60px; text-align: right;'
                    ]
                ])
                ->add('origen', null, [
                    'label' => 'Origen',
                    'attr' => [
                        'style' => 'width: 120px;'
                    ]
                ])
                ->add('destino', null, [
                    'label' => 'Destino',
                    'attr' => [
                        'style' => 'width: 120px;'
                    ]
                ])
                ->add('nota', null, [
                    'label' => 'Nota',
                    'attr' => [
                        'style' => 'width: 160px;'
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
            ->add('servicio')
            ->add('hora')
            ->add('nombre')
            ->add('codigo', null, [
                'label' => 'Código'
            ])
            ->add('numadl', null, [
                'label' => 'Adultos'
            ])
            ->add('numchd', null, [
                'label' => 'Niños'
            ])
            ->add('origen')
            ->add('destino')
            ->add('nota')
        ;
    }

}
