<?php

namespace Gopro\CotizacionBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\CollectionType;
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
            ['GoproCotizacionBundle:CotizacionAdmin:form_admin_fields.html.twig']
        );
    }

    public function getActionButtons($action, $object = null)
    {
        $list = parent::getActionButtons($action, $object);

        $list['resumen'] = [
            'template' => 'GoproCotizacionBundle:CotizacionAdmin:resumen_button.html.twig',
        ];

        return $list;
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
            ->add('primerCotservicioFecha', 'datetime', [
                'label' => 'Fecha Inicio',
                'format' => 'Y/m/d',
            ])
            ->add('file', null, [
                'sortable' => true,
                'sort_field_mapping' => ['fieldName' => 'nombre'],
                'sort_parent_association_mappings' => [['fieldName' => 'file']]
            ])
            ->add('nombre', null, [
                'editable' => true,
            ])
            ->add('titulo', null, [
                'label' => 'Título',
                'editable' => true
            ])
            ->add('numeropasajeros', null, [
                'label' => 'Num Pax'
            ])
            ->add('comision', null, [
                'label' => 'Comisión'
            ])
            ->add('estadocotizacion', 'choice', [
                'sortable' => true,
                'sort_field_mapping' => ['fieldName' => 'nombre'],
                'sort_parent_association_mappings' => [['fieldName' => 'estadocotizacion']],
                'label' => 'Estado',
                'editable' => true,
                'class' => 'Gopro\CotizacionBundle\Entity\Estadocotizacion',
                'choices' => [
                    1 => 'Pendiente',
                    2 => 'Enviado',
                    3 => 'Aceptado',
                    4 => 'Efectuado'
                ]
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
            ->add('cotservicios', CollectionType::class, [
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
