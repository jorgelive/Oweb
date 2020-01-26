<?php

namespace Gopro\ServicioBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Sonata\AdminBundle\Show\ShowMapper;

class ItinerarioAdmin extends AbstractAdmin
{

    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'servicio',
    ];

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
            ->add('servicio')
            ->add('nombre')
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
            ->add('servicio', null, [
                'sortable' => true,
                'sort_field_mapping' => ['fieldName' => 'nombre'],
                'sort_parent_association_mappings' => [['fieldName' => 'servicio']]
            ])
            ->add('nombre', null, [
                'editable' => true
            ])
            ->add('hora', 'datetime', [
                'format' => 'H:i',
                'row_align' => 'right'
            ])
            ->add('duracion', null, [
                'label' => 'Duración',
                'row_align' => 'right'
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
            ->add('itinerariodias', CollectionType::class, [
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
