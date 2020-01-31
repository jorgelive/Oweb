<?php

namespace Gopro\CotizacionBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Form\Type\DatePickerType;

class FilepasajeroAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('file')
            ->add('nombre')
            ->add('apellido')
            ->add('sexo')
            ->add('pais', null, [
                'label' => 'País'
            ])
            ->add('tipodocumento', null, [
                'label' => 'Tipo de documento'
            ])
            ->add('numerodocumento', null, [
                'label' => 'Número de Documento'
            ])
            ->add('fechanacimiento', null, [
                'label' => 'Fecha de nacimiento'
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
            ->add('file', null, [
                'sortable' => true,
                'sort_field_mapping' => ['fieldName' => 'nombre'],
                'sort_parent_association_mappings' => [['fieldName' => 'file']]
            ])
            ->add('nombre', null, [
                'editable' => true
            ])
            ->add('apellido', null, [
                'editable' => true
            ])
            ->add('sexo')
            ->add('pais', null, [
                'label' => 'País'
            ])
            ->add('tipodocumento', null, [
                'label' => 'Tipo de documento'
            ])
            ->add('numerodocumento', null, [
                'label' => 'Número de Documento',
                'row_align' => 'right',
                'editable' => true
            ])
            ->add('fechanacimiento', 'date', [
                'label' => 'Fecha de nacimiento',
                'editable' => true,
                'row_align' => 'right',
                'format' => 'Y/m/d'
            ])
            ->add('edad')
            ->add('_action', null, [
                'label' => 'Acciones',
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => []
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
            ->add('apellido')
            ->add('sexo')
            ->add('pais', null, [
                'label' => 'País'
            ])
            ->add('tipodocumento', null, [
                'label' => 'Tipo de documento'
            ])
            ->add('numerodocumento', null, [
                'label' => 'Número de Documento'
            ])
            ->add('fechanacimiento', DatePickerType::class, [
                'label' => 'Fecha de nacimieto',
                'dp_use_current' => true,
                'dp_show_today' => true,
                'format'=> 'yyyy/MM/dd'
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
            ->add('file')
            ->add('nombre')
            ->add('apellido')
            ->add('sexo')
            ->add('pais', null, [
                'label' => 'País'
            ])
            ->add('tipodocumento', null, [
                'label' => 'Tipo de documento'
            ])
            ->add('numerodocumento', null, [
                'label' => 'Número de Documento'
            ])
            ->add('fechanacimiento', null, [
                'label' => 'Fecha de nacimiento'
            ])
            ->add('edad')
        ;
    }

    public function getDataSourceIterator()
    {
        $datasourceit = parent::getDataSourceIterator();
        $datasourceit->setDateTimeFormat('Y/m/d');
        return $datasourceit;
    }

    public function getExportFields()
    {
        $ret['File'] = 'file';
        $ret['Nombre'] = 'nombre';
        $ret['Apellido'] = 'apellido';
        $ret['Tipo de documento'] = 'tipodocumento';
        $ret['Número de documento'] = 'numerodocumento';
        $ret['Sexo'] = 'sexo';
        $ret['Pais'] = 'pais';
        $ret['Edad'] = 'edad';
        $ret['Fecha de Nacimiento'] = 'fechanacimiento';

        return $ret;
    }

    public function getExportFormats()
    {
        return ['xlsx', 'txt', 'xls', 'csv', 'json', 'xml'];
    }
}
