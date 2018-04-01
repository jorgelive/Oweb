<?php

namespace Gopro\ServicioBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\TranslationBundle\Filter\TranslationFieldFilter;

class ComponenteAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('nombre')
            ->add('titulo', TranslationFieldFilter::class, [
                'label' => 'Título'
            ])
            ->add('tipocomponente', null, [
                'label' => 'Tipo'
            ])
            ->add('duracion', null, [
                'label' => 'Duración'
            ])
            ->add('servicios')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('nombre')
            ->add('titulo', null, [
                'label' => 'Título'
            ])
            ->add('tipocomponente', null, [
                'label' => 'Tipo'
            ])
            ->add('duracion', null, [
                'label' => 'Duración'
            ])
            ->add('tarifas')
            ->add('servicios')
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
        $formMapper
            ->add('nombre')
            ->add('titulo', null, [
                'label' => 'Título'
            ])
            ->add('tipocomponente', null, [
                'label' => 'Tipo'
            ])
            ->add('duracion', null, [
                'label' => 'Duración'
            ])
            ->add('servicios', null,[
                'by_reference' => false
            ])
            ->add('tarifas', CollectionType::class, [
                'by_reference' => false,
                'label' => 'Tarifas'
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
        $showMapper
            ->add('id')
            ->add('nombre')
            ->add('titulo', null, [
                'label' => 'Título'
            ])
            ->add('tipocomponente', null, [
                'label' => 'Tipo'
            ])
            ->add('duracion', null, [
                'label' => 'Duración'
            ])
            ->add('servicios')
            ->add('tarifas')
        ;
    }
}
