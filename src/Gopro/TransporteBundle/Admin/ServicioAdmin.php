<?php

namespace Gopro\TransporteBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\CoreBundle\Form\Type\EqualType;
use Sonata\CoreBundle\Form\Type\BooleanType;
use Symfony\Component\Validator\Constraints\DateTime;

class ServicioAdmin extends AbstractAdmin
{

    protected $datagridValues = [
        '_sort_order' => 'ASC',
        '_sort_by' => 'fechahorainicio',
    ];

    public function getFilterParameters(){

        $fecha = new \DateTime();

        $this->datagridValues = array_merge(array(
            'fechahorainicio' => array (
                'value' => $fecha->format('Y/m/d')
            )
        ), $this->datagridValues);

        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        if(!is_null($user) && !is_null($user->getConductor())){
            $this->datagridValues = array_merge(array(
                'conductor' => array (
                    'value' => $user->getConductor()->getId()
                )
            ), $this->datagridValues);
        }

        return parent::getFilterParameters();
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('fechahorainicio', 'doctrine_orm_callback',
                array(
                    'label' => 'Inicio',
                    'callback' => function($queryBuilder, $alias, $field, $value) {
                        if (!$value['value'] || !($value['value'] instanceof \DateTime)) {
                            return;
                        }
                        $fechaMasUno = clone ($value['value']);
                        $fechaMasUno->add(new \DateInterval('P1D'));
                        $queryBuilder->andWhere("DATE($alias.fechahorainicio) >= :fechahora");
                        $queryBuilder->andWhere("DATE($alias.fechahorainicio) < :fechahoraMasUno");
                        $queryBuilder->setParameter('fechahora', $value['value']);
                        $queryBuilder->setParameter('fechahoraMasUno', $fechaMasUno);
                        return true;
                    },
                    'field_type'=>'sonata_type_date_picker',
                    'field_options'=> [
                        'dp_use_current' => true,
                        'dp_show_today' => true,
                        'format'=> 'yyyy/MM/dd'
                    ]
                ))
            ->add('dependencia.organizacion', null, [
                'route' => ['name' => 'show']
            ])
            ->add('unidad')
            ->add('conductor')
            ->add('nombre')
        ;
    }



    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('fechahorainicio',  null, [
                'label' => 'Inicio',
                'format' => 'Y/m/d H:i'
            ])
            ->addIdentifier('nombre')
            ->add('dependencia.organizacion', null, [
                'route' => ['name' => 'show'],
                'label' => 'Cliente'
            ])
            ->add('unidad', null, [
                'associated_property' => 'abreviatura',
                'route' => ['name' => 'show']
            ])
            ->add('conductor', null, [
                'route' => ['name' => 'show']
            ])
            ->add('fechahorafin',  null, [
                'label' => 'Fin',
                'format' => 'H:i'
            ])
             ->add('_action', 'actions', [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ]
            ])
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('fechahorainicio', 'sonata_type_datetime_picker', [
                'label' => 'Inicio',
                'dp_use_current' => true,
                'dp_show_today' => true,
                'format'=> 'yyyy/MM/dd HH:mm'
            ])
            ->add('fechahorafin', 'sonata_type_datetime_picker', [
                'label' => 'Fin',
                'dp_use_current' => true,
                'dp_show_today' => true,
                'format'=> 'yyyy/MM/dd HH:mm'
            ])
            ->add('nombre')
            ->add('dependencia', null, [
                'choice_label' => 'organizaciondependencia',
                'label' => 'Cliente'
            ])
            ->add('unidad')
            ->add('conductor')
             ->add('serviciooperativos', 'sonata_type_collection',[
                'by_reference' => false,
                'label' => 'Operativo'
            ], [
                'edit' => 'inline',
                'inline' => 'table',
            ])
            ->add('serviciofiles', 'sonata_type_collection', [
                'by_reference' => false,
                'label' => 'Files'
            ], [
                'edit' => 'inline',
                'inline' => 'table'
            ])
            ->add('serviciocontables', 'sonata_type_collection', [
                'by_reference' => false,
                'label' => 'Facturación'
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
            ->add('fechahorainicio',  null, [
                'label' => 'Inicio',
                'format' => 'Y/m/d H:i'
            ])
            ->add('nombre')
            ->add('dependencia.organizacion', null, [
                'route' => ['name' => 'show'],
                'label' => 'Cliente'
            ])
            ->add('unidad', null, [
                'route' => ['name' => 'show']
            ])
            ->add('conductor', null, [
                'route' => ['name' => 'show']
            ])
            ->add('fechahorafin',  null, [
                'label' => 'Fin',
                'format' => 'Y/m/d H:i'
            ])
            ->end()
            ->with('Informacion Operativa')
            ->add('serviciooperativos', 'collection', [
                'template' => 'GoproTransporteBundle:ServicioAdmin:show_serviciooperativo_collection.html.twig'
            ])
            ->end()
            ->with('Files')
            ->add('serviciofiles', 'collection', [
                'template' => 'GoproTransporteBundle:ServicioAdmin:show_serviciofile_collection.html.twig'
            ])
            ->end()
        ;
    }

}
