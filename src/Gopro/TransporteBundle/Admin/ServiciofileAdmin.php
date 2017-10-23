<?php

namespace Gopro\TransporteBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

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
