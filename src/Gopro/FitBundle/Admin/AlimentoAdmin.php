<?php

namespace Gopro\FitBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\DatePickerType;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;

class AlimentoAdmin extends AbstractAdmin
{


    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('nombre')
            ->add('grasa')
            ->add('carbohidrato')
            ->add('proteina')

            ->add('proteinaaltovalor', null, [
                'label' => 'Proteina de alto valor'
            ])
            ->add('cantidad')
            ->add('medidaalimento', null, [
                'label' => 'Medida de alimento'
            ])
            ->add('tipoalimento', null, [
                'label' => 'Típo de alimento'
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
            ->add('nombre', null, [
                'editable' => true
            ])
            ->add('grasa')
            ->add('carbohidrato')
            ->add('proteina', null, [
                'editable' => true
            ])
            ->add('proteinaaltovalor', null, [
                'label' => 'Proteina de alto valor'
            ])
            ->add('cantidad')
            ->add('medidaalimento', null, [
                'label' => 'Medida de alimento'
            ])
            ->add('tipoalimento', null, [
                'label' => 'Típo de alimento'
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

        $formMapper
            ->add('nombre')
            ->add('grasa')
            ->add('carbohidrato')
            ->add('proteina')
            ->add('proteinaaltovalor', null, [
                'label' => 'Proteina de alto valor'
            ])
            ->add('cantidad')
            ->add('medidaalimento', null, [
                'label' => 'Medida de alimento'
            ])
            ->add('tipoalimento', null, [
                'label' => 'Típo de alimento'
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
            ->add('grasa')
            ->add('carbohidrato')
            ->add('proteina')
            ->add('proteinaaltovalor', null, [
                'label' => 'Proteina de alto valor'
            ])
            ->add('cantidad')
            ->add('medidaalimento', null, [
                'label' => 'Medida de alimento'
            ])
            ->add('tipoalimento', null, [
                'label' => 'Típo de alimento'
            ])
        ;
    }
}
