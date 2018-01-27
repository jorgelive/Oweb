<?php

namespace Gopro\ServicioBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class ItinerarioAdmin extends AbstractAdmin
{

    public function getFormTheme()
    {
        return array_merge(
            parent::getFormTheme(),
            array('GoproServicioBundle:ItinerarioAdmin:form_admin_fields.html.twig')
        );
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('nombre')
            ->add('servicio')
            ->add('hora', null, [
                'with_seconds' => false
            ])
            ->add('duracion', null, [
                'label' => 'Duración'
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
            ->add('nombre')
            ->add('servicio')
            ->add('hora', 'datetime', [
                'format' => 'H:i'
            ])
            ->add('duracion', null, [
                'label' => 'Duración'
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
        if ($this->getRoot()->getClass() != 'Gopro\ServicioBundle\Entity\Servicio'){
            $formMapper->add('servicio');
        }
        $formMapper
            ->add('nombre')
            ->add('hora', null, [
                'with_seconds' => false
            ])
            ->add('duracion', null, [
                'label' => 'Duración'
            ])
            ->add('itinerariodias', 'sonata_type_collection', [
                'by_reference' => false,
                'label' => 'Dias'
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
            ->add('servicio')
            ->add('hora', 'datetime', [
                'format' => 'H:i'
            ])
            ->add('duracion', null, [
                'label' => 'Duración'
            ])
            ->add('itinerariodias', null, [
                'label' => 'Dias'
            ])
        ;
    }
}
