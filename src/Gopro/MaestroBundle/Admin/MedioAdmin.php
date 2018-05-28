<?php

namespace Gopro\MaestroBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\TranslationBundle\Filter\TranslationFieldFilter;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class MedioAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('clasemedio', null, [
                    'label' => 'Clase'
                ]
            )
            ->add('nombre')
            ->add('titulo', TranslationFieldFilter::class, [
                'label' => 'Título'
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
            ->add('clasemedio', null, [
                    'label' => 'Clase'
                ]
            )
            ->add('webThumbPath', 'string', [
                    'label' => 'Archivo',
                    'template' => 'GoproSonataBundle:Admin:list_image.html.twig'
                ]
            )
            ->add('nombre', null, [
                'editable' => true
            ])
            ->add('titulo', null, [
                'label' => 'Título',
                'editable' => true
            ])
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

        $formMapper
            ->add('clasemedio', null, [
                    'label' => 'Clase'
                ]
            )
            ->add('nombre', null, [
                'attr' => ['class' => 'uploadedimage']
            ])
            ->add('titulo', null, [
                'label' => 'Título'
            ])
            ->add('archivo', FileType::class, [
                'required' => false
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
            ->add('webThumbPath', null, [
                    'label' => 'Archivo'
                ]
            )
            ->add('clasemedio', null, [
                    'label' => 'Clase'
                ]
            )
            ->add('nombre')
            ->add('titulo', null, [
                'label' => 'Título'
            ])
        ;
    }

    public function prePersist($medio)
    {
        $this->manageFileUpload($medio);
    }

    public function preUpdate($medio)
    {
        $this->manageFileUpload($medio);
    }

    private function manageFileUpload($medio)
    {
        if ($medio->getArchivo()) {
            $medio->refreshModificado();
        }
    }

}
