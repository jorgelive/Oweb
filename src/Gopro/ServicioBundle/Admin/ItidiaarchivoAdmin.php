<?php

namespace Gopro\ServicioBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\TranslationBundle\Filter\TranslationFieldFilter;

class ItidiaarchivoAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('nombre')
            ->add('titulo', TranslationFieldFilter::class, [
                'label' => 'Título'
            ])
            ->add('prioridad')
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
            ->add('titulo', null, [
                'label' => 'Título'
            ])
            ->add('prioridad')
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

        if ($this->getRoot()->getClass() != 'Gopro\ServicioBundle\Entity\Itinerariodia' &&
            $this->getRoot()->getClass() != 'Gopro\ServicioBundle\Entity\Itinerario' &&
            $this->getRoot()->getClass() != 'Gopro\ServicioBundle\Entity\Servicio'
        ){
            $formMapper->add('itinerariodia', null, [
                'label' => 'Dia de itineratio'
                ]
            );
        }
        $formMapper
            ->add('nombre', null, [
                'attr' => ['class' => 'uploadedimage']
            ])
            ->add('titulo', null, [
                'label' => 'Título'
            ])
            ->add('prioridad')
            ->add('archivo', 'file', [
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
            ->add('nombre')
            ->add('titulo', null, [
                'label' => 'Título'
            ])
            ->add('prioridad')
        ;
    }

    public function prePersist($itidiaarchivo)
    {
        $this->manageFileUpload($itidiaarchivo);
    }

    public function preUpdate($itidiaarchivo)
    {
        $this->manageFileUpload($itidiaarchivo);
    }

    private function manageFileUpload($itidiaarchivo)
    {
        if ($itidiaarchivo->getFile()) {
            $itidiaarchivo->refreshUpdated();
        }
    }

}
