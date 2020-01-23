<?php

namespace Gopro\FitBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class DietaAdmin extends AbstractAdmin
{

    public $vars;

    public function getFormTheme()
    {
        return array_merge(
            parent::getFormTheme(),
            ['GoproFitBundle:DietaAdmin:form_admin_fields.html.twig']
        );
    }

/*    public function getActionButtons($action, $object = null)
    {
        $list = parent::getActionButtons($action, $object);

        $list['resumen'] = [
            'template' => 'GoproFitBundle:CotizacionAdmin:resumen_button.html.twig',
        ];

        return $list;
    }*/

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('nombre')
            ->add('peso', null, [
                'label' => 'Peso'
            ])
            ->add('indicedegrasa', null, [
                'label' => 'Indice de grasa'
            ])
            ->add('tipodieta', null, [
                'label' => 'Tipo de dieta'
            ])
            ->add('fecha', null, [
                'label' => 'Fecha'
            ])
            ->add('user', null, [
                'label' => 'Usuario'
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
                'editable' => true,
            ])
            ->add('peso', null, [
                'label' => 'Peso',
                'editable' => true
            ])
            ->add('indicedegrasa', null, [
                'label' => 'Indice de grasa',
                'editable' => true
            ])
            ->add('tipodieta', null, [
                'label' => 'Tipo de dieta'
            ])
            ->add('fecha', null, [
                'label' => 'Fecha',
                'format' => 'Y/m/d'
            ])
            ->add('user', null, [
                'label' => 'Usuario'
            ])



            ->add('_action', null, [
                'label' => 'Acciones',
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                    'clonar' => [
                        'template' => 'GoproFitBundle:DietaAdmin:list__action_clonar.html.twig'
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
        $formMapper
            ->add('nombre')
            ->add('peso', null, [
                'label' => 'Peso'
            ])
            ->add('indicedegrasa', null, [
                'label' => 'Indice de grasa'
            ])
            ->add('tipodieta', null, [
                'label' => 'Tipo de dieta'
            ])
            ->add('fecha', null, [
                'label' => 'Fecha'
            ])
            ->add('user', null, [
                'label' => 'Usuario'
            ])
            ->add('dietacomidas', CollectionType::class , [
                'by_reference' => false,
                'label' => 'Comidas'
            ], [
                'edit' => 'inline',
                'inline' => 'table'
            ])
        ;

        $this->vars['dietaalimentos']{'alimentopath'} = 'gopro_fit_alimento_ajaxinfo';
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('nombre')
            ->add('peso', null, [
                'label' => 'Peso'
            ])
            ->add('indicedegrasa', null, [
                'label' => 'Indice de grasa'
            ])
            ->add('tipodieta', null, [
                'label' => 'Tipo de dieta'
            ])
            ->add('fecha', null, [
                'label' => 'Fecha'
            ])
            ->add('user', null, [
                'label' => 'Usuario'
            ])

        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        //$collection->add('resumen', $this->getRouterIdParameter() . '/resumen');
        $collection->add('clonar', $this->getRouterIdParameter() . '/clonar');
    }
}
