<?php

namespace Gopro\ServicioBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\TranslationBundle\Filter\TranslationFieldFilter;

class ServicioAdmin extends AbstractAdmin
{

    public function getFormTheme()
    {
        return array_merge(
            parent::getFormTheme(),
            array('GoproServicioBundle:ServicioAdmin:form_admin_fields.html.twig')
        );
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('codigo', null, [
                'label' => 'Código'
            ])
            ->add('nombre')
            ->add('paralelo')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('codigo', null, [
                'label' => 'Código'
            ])
            ->add('nombre')
            ->add('paralelo')
            ->add('componentes')
            ->add('itinerarios')
            ->add('_action', null, [
                'label' => 'Acciones',
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => []
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
            ->add('codigo', null, [
                'label' => 'Código'
            ])
            ->add('nombre')
            ->add('paralelo')
            ->add('componentes')
            ->add('itinerarios', 'sonata_type_collection', [
                'by_reference' => false,
                'label' => 'Itinerarios'
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
            ->add('codigo', null, [
                'label' => 'Código'
            ])
            ->add('nombre')
            ->add('paralelo')
            ->add('componentes')
            ->add('itinerarios')
        ;
    }
}
