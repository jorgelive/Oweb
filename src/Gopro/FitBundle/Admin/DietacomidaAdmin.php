<?php

namespace Gopro\FitBundle\Admin;

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

class DietacomidaAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('numerocomida', null, [
                'label' => 'Número de comida'
            ])
            ->add('nota', null, [
                'label' => 'Nota'
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
            ->add('numerocomida', null, [
                'label' => 'Número de comida'
            ])
            ->add('nota', null, [
                'label' => 'Nota'
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
        if ($this->getRoot()->getClass() != 'Gopro\FitBundle\Entity\Dieta'
        ){
            $formMapper->add('dieta', null, [
                'label' => 'Dieta'
            ]);
        }

        $formMapper
            ->add('numerocomida', null, [
                    'label' => 'Número de comida'
            ])
            ->add('nota', null, [
                'label' => 'Nota'
            ])
            ->add('dietaalimentos', CollectionType::class , [
                'by_reference' => false,
                'label' => 'Alimentos'
            ], [
                'edit' => 'inline',
                'inline' => 'table'
            ])
        ;

    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {


        $showMapper->add('dieta', null, [
            'label' => 'Dieta'
            ])
            ->add('numerocomida', null, [
                'label' => 'Número de comida'
            ])
            ->add('nota', null, [
                'label' => 'Nota'
            ])
            ->add('dietaalimentos', null , [
                'label' => 'Alimentos'
            ])
        ;

    }
}
