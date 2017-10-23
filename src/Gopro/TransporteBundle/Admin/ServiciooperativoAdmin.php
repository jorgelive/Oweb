<?php

namespace Gopro\TransporteBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ServiciooperativoAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('tiposeroperativo', null, [
                'label' => 'Tipo'
            ])
            ->add('texto', null, [
                'label' => 'Contenido'
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
            ->add('tiposeroperativo', null, [
                'label' => 'Tipo'
            ])
            ->add('texto', null, [
                'label' => 'Contenido'
            ])
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
            ->add('tiposeroperativo', null, [
                'label' => 'Tipo'
            ])
            ->add('texto', null, [
                'label' => 'Contenido'
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
            ->add('tiposeroperativo', null, [
                'label' => 'Tipo'
            ])
            ->add('texto', null, [
                'label' => 'Contenido'
            ])
        ;
    }

}
