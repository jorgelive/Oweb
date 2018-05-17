<?php

namespace Gopro\ComprobanteBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class ComprobanteitemAdmin extends AbstractAdmin
{

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('productoservicio',  null, [
                'label' => 'Producto / Servicio'
            ])
            ->add('unitario')
            ->add('comprobante')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('productoservicio',  null, [
                'label' => 'Producto / Servicio'
            ])
            ->add('cantidad')
            ->add('unitario')
            ->add('comprobante')
            ->add('_action', 'actions', [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => []
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
        if ($this->getRoot()->getClass() != 'Gopro\ComprobanteBundle\Entity\Comprobante'){
            $formMapper->add('comprobante');
        }
        $formMapper
            ->add('productoservicio',  null, [
                'label' => 'Producto / Servicio'
            ])
            ->add('cantidad')
            ->add('unitario')
        ;

        $widthModifier = function (FormInterface $form) {

            $form
                ->add('unitario', null, [
                    'label' => 'Unitario',
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
                    && $this->getRoot()->getClass() == 'Gopro\ComprobanteBundle\Entity\Comprobante'
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
            ->add('productoservicio',  null, [
                'label' => 'Producto / Servicio'
            ])
            ->add('cantidad')
            ->add('unitario')
            ->add('comprobante')
        ;
    }


}
