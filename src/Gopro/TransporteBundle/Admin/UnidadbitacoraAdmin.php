<?php

namespace Gopro\TransporteBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\DatePickerType;

class UnidadbitacoraAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('unidad')
            ->add('tipounibit', null, [
                'label' => 'Tipo'
            ])
            ->add('contenido')
            ->add('kilometraje')
            ->add('fecha')

        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('unidad')
            ->add('tipounibit', null, [
                'label' => 'Tipo'
            ])
            ->add('contenido')
            ->add('kilometraje')
            ->add('fecha')
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
        if ($this->getRoot()->getClass() != 'Gopro\TransporteBundle\Entity\Unidad'){
            $formMapper->add('unidad');
        }

        $formMapper
            ->add('tipounibit', null, [
                'label' => 'Tipo'
            ])
            ->add('contenido')
            ->add('kilometraje')
            ->add('fecha', DatePickerType::class, [
                'label' => 'Fecha',
                'dp_use_current' => true,
                'dp_show_today' => true,
                'format'=> 'yyyy/MM/dd'
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
            ->add('unidad')
            ->add('tipounibit', null, [
                'label' => 'Tipo'
            ])
            ->add('contenido')
            ->add('kilometraje')
            ->add('fecha')
        ;
    }

}
