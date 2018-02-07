<?php

namespace Gopro\CotizacionBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class CotizacionAdmin extends AbstractAdmin
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
            array('GoproCotizacionBundle:CotizacionAdmin:form_admin_fields.html.twig')
        );
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('file')
            ->add('nombre')
            ->add('titulo', null, [
                'label' => 'Título'
            ])
            ->add('numeropasajeros', null, [
                'label' => 'Cantidad de pasajeros'
            ])
            ->add('comision', null, [
                'label' => 'Comisión'
            ])
            ->add('estadocotizacion', null, [
                'label' => 'Estado'
            ])
            ->add('cotpolitica', null, [
                'label' => 'Política'
            ])
            ->add('cotnotas',  null, [
                'label' => 'Notas'
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
            ->add('file')
            ->add('nombre')
            ->add('titulo', null, [
                'label' => 'Título'
            ])
            ->add('numeropasajeros', null, [
                'label' => 'Num Pax'
            ])
            ->add('comision', null, [
                'label' => 'Comisión'
            ])
            ->add('estadocotizacion', null, [
                'label' => 'Estado'
            ])
            ->add('cotpolitica', null, [
                'label' => 'Política'
            ])
            ->add('cotnotas',  null, [
                'label' => 'Notas'
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
                    'resumen' => [
                        'template' => 'GoproCotizacionBundle:CotizacionAdmin:list__action_resumen.html.twig'
                    ],
                    'clonar' => [
                        'template' => 'GoproCotizacionBundle:CotizacionAdmin:list__action_clonar.html.twig'
                    ]
                ]
            ])
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {

        if ($this->getRoot()->getClass() != 'Gopro\CotizacionBundle\Entity\File'){
            $formMapper->add('file');
        }
        $formMapper
            ->add('nombre')
            ->add('titulo', null, [
                'label' => 'Título'
            ])
            ->add('numeropasajeros', null, [
                'label' => 'Num Pax'
            ])
            ->add('comision', null, [
                'label' => 'Comisión'
            ])
            ->add('estadocotizacion', null, [
                'label' => 'Estado'
            ])
            ->add('cotpolitica', null, [
                'label' => 'Política'
            ])
            ->add('cotnotas',  null, [
                'label' => 'Notas'
            ])
            ->add('cotservicios', 'sonata_type_collection', [
                'by_reference' => false,
                'label' => 'Servicios'
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
            ->add('file')
            ->add('nombre')
            ->add('titulo', null, [
                'label' => 'Título'
            ])
            ->add('numeropasajeros', null, [
                'label' => 'Cantidad de pasajeros'
            ])
            ->add('comision', null, [
                'label' => 'Comisión'
            ])
            ->add('estadocotizacion', null, [
                'label' => 'Estado'
            ])
            ->add('cotpolitica', null, [
                'label' => 'Política'
            ])
            ->add('cotnotas',  null, [
                'label' => 'Notas'
            ])

        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('resumen', $this->getRouterIdParameter() . '/resumen');
        $collection->add('clonar', $this->getRouterIdParameter() . '/clonar');
    }
}
