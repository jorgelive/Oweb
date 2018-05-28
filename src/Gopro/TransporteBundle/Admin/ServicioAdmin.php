<?php

namespace Gopro\TransporteBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Sonata\CoreBundle\Form\Type\DateTimePickerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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

        $this->datagridValues = array_merge([
            'fechahorainicio' => [
                'value' => $fecha->format('Y/m/d')
            ]
        ], $this->datagridValues);

        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        if(!is_null($user) && !is_null($user->getConductor())){
            $this->datagridValues = array_merge([
                'conductor' => [
                    'value' => $user->getConductor()->getId()
                ]
            ], $this->datagridValues);
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
            ->add('fechahorainicio', 'doctrine_orm_callback',[
                'label' => 'Inicio',
                'callback' => function($queryBuilder, $alias, $field, $value) {

                    if (!$value['value'] || !($value['value'] instanceof \DateTime)) {
                        return false;
                    }
                    $fechaMasUno = clone ($value['value']);
                    $fechaMasUno->add(new \DateInterval('P1D'));

                    if(empty($value['type'])){
                        $queryBuilder->andWhere("DATE($alias.$field) >= :fechahora");
                        $queryBuilder->andWhere("DATE($alias.$field) < :fechahoraMasUno");
                        $queryBuilder->setParameter('fechahora', $value['value']);
                        $queryBuilder->setParameter('fechahoraMasUno', $fechaMasUno);
                        return true;
                    } elseif($value['type'] == 1){
                        $queryBuilder->andWhere("DATE($alias.$field) >= :fechahora");
                        $queryBuilder->setParameter('fechahora', $value['value']);
                        return true;
                    } elseif($value['type'] == 2){
                        $queryBuilder->andWhere("DATE($alias.$field) < :fechahoraMasUno");
                        $queryBuilder->setParameter('fechahoraMasUno', $fechaMasUno);
                        return true;
                    } elseif($value['type'] == 3){
                        $queryBuilder->andWhere("DATE($alias.$field) >= :fechahoraMasUno");
                        $queryBuilder->setParameter('fechahoraMasUno', $fechaMasUno);
                        return true;
                    } elseif($value['type'] == 4){
                        $queryBuilder->andWhere("DATE($alias.$field) < :fechahora");
                        $queryBuilder->setParameter('fechahora', $value['value']);
                        return true;
                    }

                    return true;

                },
                'field_type' => DatePickerType::class,
                'field_options' => [
                    'dp_use_current' => true,
                    'dp_show_today' => true,
                    'format'=> 'yyyy/MM/dd'
                ],
                'operator_type' => ChoiceType::class,
                'operator_options' => [
                    'choices' => [
                        'Igual a' => 0,
                        'Mayor o igual a' => 1,
                        'Menor o igual a' => 2,
                        'Mayor a' => 3,
                        'Menor a' => 4
                    ]
                ]
            ]);

        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        if($user && $user->getDependencia() && $user->getDependencia()->getId() == 1) {
            $datagridMapper
                ->add('dependencia.organizacion', null, [
                    'label' => 'Cliente'
                ]);
        }

        $datagridMapper
            ->add('unidad')
            ->add('conductor')
            ->add('nombre',  null, [
                'label' => 'Servicio'
            ])
            ->add('serviciocomponentes.nombre',  null, [
                'label' => 'Nombre File'
            ])
            ->add('serviciocomponentes.codigo',  null, [
                'label' => 'Número File'
            ])
        ;
    }


    public function createQuery($context = 'list')
    {
        $query = parent::createQuery($context);

        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        if($user && $user->getDependencia() && $user->getDependencia()->getId() != 1){
            $user->getDependencia()->getId();
            $rootAlias = $query->getRootAliases()[0];
            $query->andWhere(
                $query->expr()->eq($rootAlias.'.dependencia', ':dependencia')
            );
            $query->setParameter(':dependencia', $user->getDependencia()->getId());
        }

        return $query;
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
            ->add('serviciocomponentes', null, [
                'associated_property' => 'resumen',
                'label' => 'Referencias'
            ])
            ->add('serviciooperativos', null, [
                'associated_property' => 'resumen',
                'label' => 'Info operativa'
            ])
            ->add('fechahorafin',  null, [
                'label' => 'Fin',
                'format' => 'H:i'
            ]);

        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        if($user && $user->getDependencia() && $user->getDependencia()->getId() == 1) {
            $listMapper
                ->add('dependencia.organizacion', null, [
                    'label' => 'Cliente'
                ]);
        }

        $listMapper
            ->add('unidad', null, [
                'associated_property' => 'abreviatura',
                'route' => ['name' => 'show']
            ])
            ->add('conductor', null, [
                'route' => ['name' => 'show']
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
        $formMapper
            ->tab('General')
                ->with('Info')
                    ->add('fechahorainicio', DateTimePickerType::class, [
                        'label' => 'Inicio',
                        'dp_use_current' => true,
                        'dp_show_today' => true,
                        'format'=> 'yyyy/MM/dd HH:mm'
                    ])
                    ->add('fechahorafin', DateTimePickerType::class, [
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
                ->end()
                ->with('Información Operativa')
                    ->add('serviciooperativos', CollectionType::class,[
                        'by_reference' => false,
                        'label' => false
                    ], [
                        'edit' => 'inline',
                        'inline' => 'table'
                    ])
                ->end()
                ->with('Componentes')
                    ->add('serviciocomponentes', CollectionType::class, [
                        'by_reference' => false,
                        'label' => false
                    ], [
                        'edit' => 'inline',
                        'inline' => 'table'
                    ])
                ->end()
            ->end()
            ->tab('Contable')
                ->with('Documentos')
                    ->add('serviciocontables', CollectionType::class, [
                        'by_reference' => false,
                        'label' => false
                    ], [
                        'edit' => 'inline',
                        'inline' => 'table'
                    ])
                ->end()
            ->end()
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
            ->add('nombre');

        $user = $this->getConfigurationPool()->getContainer()->get('security.token_storage')->getToken()->getUser();
        if($user && $user->getDependencia() && $user->getDependencia()->getId() == 1) {
            $showMapper
                ->add('dependencia.organizacion', null, [
                    'label' => 'Cliente'
                ]);
        }

        $showMapper
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
            ->with('Información Operativa')
            ->add('serviciooperativos', 'collection', [
                'template' => 'GoproTransporteBundle:ServicioAdmin:show_serviciooperativo_collection.html.twig'
            ])
            ->end()
            ->with('Componentes')
            ->add('serviciocomponentes', 'collection', [
                'template' => 'GoproTransporteBundle:ServicioAdmin:show_serviciocomponente_collection.html.twig'
            ])
            ->end()
        ;
    }

    public function getDataSourceIterator()
    {
        $datasourceit = parent::getDataSourceIterator();
        $datasourceit->setDateTimeFormat('Y/m/d H:i');
        return $datasourceit;
    }

    public function getExportFields()
    {
        $ret['Inicio'] = 'fechahorainicio';
        $ret['Servicio'] = 'nombre';
        $ret['Componentes'] = 'exportcomponentes';
        $ret['Operativa'] = 'exportoperativos';
        $ret['Unidad'] = 'unidad';
        $ret['Conductor'] = 'conductor';
        $ret['Cliente'] = 'dependencia.organizacion';

        return $ret;
    }

    public function getExportFormats()
    {
        return ['xlsx', 'txt', 'xls', 'csv', 'json', 'xml'];
    }

}
