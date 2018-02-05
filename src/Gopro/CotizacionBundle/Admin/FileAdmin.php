<?php

namespace Gopro\CotizacionBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class FileAdmin extends AbstractAdmin
{

    public $vars;

    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'DESC',
        '_sort_by' => 'modificado',
    ];

    public function getFormTheme()
    {
        return array_merge(
            parent::getFormTheme(),
            array('GoproCotizacionBundle:FileAdmin:form_admin_fields.html.twig')
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
            ->add('pais')
            ->add('idioma')
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
            ->add('pais')
            ->add('idioma')
            ->add('filedocumentos', null, [
                'label' => 'Documentos'
            ])
            ->add('cotizaciones', null, [
                'label' => 'Cotizaciones'
            ])
            ->add('modificado',  null, [
                'label' => 'Modificación',
                'format' => 'Y/m/d H:i'

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
            ->add('pais')
            ->add('idioma')
            ->add('filepasajeros', 'sonata_type_collection', [
                'by_reference' => false,
                'label' => 'Name List'
            ], [
                'edit' => 'inline',
                'inline' => 'table'
            ])
            ->add('filedocumentos', 'sonata_type_collection', [
                'by_reference' => false,
                'label' => 'Documentos'
            ], [
                'edit' => 'inline',
                'inline' => 'table'
            ])
            ->add('cotizaciones', 'sonata_type_collection', [
                'by_reference' => false,
                'label' => 'Cotizaciones'
            ], [
                'edit' => 'inline',
                'inline' => 'table'
            ])
        ;

        $this->vars['cotservicios']{'serviciopath'} = 'gopro_servicio_servicio_ajaxinfo';
        $this->vars['cotcomponentes']{'componentepath'} = 'gopro_servicio_componente_ajaxinfo';
        $this->vars['cotservicios']{'itinerariopath'} = 'gopro_servicio_itinerario_ajaxinfo';
        $this->vars['cottarifas']{'tarifapath'} = 'gopro_servicio_tarifa_ajaxinfo';

    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('nombre')
            ->add('pais')
            ->add('idioma')
            ->add('filepasajeros', null, [
                'label' => 'Name List'
            ])
            ->add('filedocumentos', null, [
                'label' => 'Documentos'
            ])
            ->add('cotizaciones', null, [
                'label' => 'Cotizaciones'
            ])
        ;
    }
}
