<?php

namespace Gopro\FitBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Sonata\CoreBundle\Form\Type\DatePickerType;
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


    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('user', null, [
                'label' => 'Usuario'
            ])
            ->add('tipodieta', null, [
                'label' => 'Tipo de dieta'
            ])
            ->add('nombre')
            ->add('peso', null, [
                'label' => 'Peso'
            ])
            ->add('indicedegrasa', null, [
                'label' => 'Indice de grasa'
            ])
            ->add('fecha', null, [
                'label' => 'Fecha'
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
            ->add('user', null, [
                'label' => 'Usuario'
            ])
            ->add('tipodieta', null, [
                'label' => 'Tipo de dieta'
            ])
            ->add('nombre', null, [
                'editable' => true,
            ])
            ->add('totalCalorias', null, [
                'label' => 'Tot cal',
                'row_align' => 'right'
            ])
            ->add('proteinaTotalPorKilogramo', null, [
                'label' => 'Prot por kg',
                'row_align' => 'right'
            ])
            ->add('peso', null, [
                'label' => 'Peso',
                'row_align' => 'right'
            ])
            ->add('indicedegrasa', null, [
                'label' => 'Indice de grasa',
                'row_align' => 'right'
            ])
            ->add('fecha', null, [
                'label' => 'Fecha',
                'format' => 'Y/m/d'
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
            ->add('user', null, [
                'label' => 'Usuario'
            ])
            ->add('tipodieta', null, [
                'label' => 'Tipo de dieta'
            ])
            ->add('nombre')
            ->add('peso', null, [
                'label' => 'Peso',
                'attr' => ['class' =>'campo-peso']
            ])
            ->add('indicedegrasa', null, [
                'label' => 'Indice de grasa',
                'attr' => ['class' =>'campo-indicedegrasa']
            ])
            ->add('fecha', DatePickerType::class, [
                'label' => 'Fecha',
                'dp_use_current' => true,
                'dp_show_today' => true,
                'format'=> 'yyyy/MM/dd'
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
            ->add('user', null, [
                'label' => 'Usuario'
            ])
            ->add('tipodieta', null, [
                'label' => 'Tipo de dieta'
            ])
            ->add('nombre')
            ->add('peso', null, [
                'label' => 'Peso'
            ])
            ->add('indicedegrasa', null, [
                'label' => 'Indice de grasa'
            ])
            ->add('fecha', null, [
                'label' => 'Fecha'
            ])


        ;
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        //$collection->add('resumen', $this->getRouterIdParameter() . '/resumen');
        $collection->add('clonar', $this->getRouterIdParameter() . '/clonar');
    }
}
