<?php

namespace Gopro\CotizacionBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class FiledocumentoAdmin extends AbstractAdmin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('nombre')
            ->add('tipofiledocumento', null, [
                'label' => 'Tipo de documento'
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
            ->add('tipofiledocumento', null, [
                'label' => 'Tipo de documento'
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

        if ($this->getRoot()->getClass() != 'Gopro\CotizacionBundle\Entity\File'){
            $formMapper->add('file');
        }
        $formMapper
            ->add('nombre', null, [
                'attr' => ['class' => 'uploadedimage']
            ])
            ->add('tipofiledocumento', null, [
                'label' => 'Tipo de documento'
            ])
            ->add('prioridad')
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
            ->add('nombre')
            ->add('tipofiledocumento', null, [
                'label' => 'Tipo de documento'
            ])
            ->add('prioridad')
        ;
    }

    public function prePersist($filedocumento)
    {
        $this->manageFileUpload($filedocumento);
    }

    public function preUpdate($filedocumento)
    {
        $this->manageFileUpload($filedocumento);
    }

    private function manageFileUpload($filedocumento)
    {
        if ($filedocumento->getArchivo()) {
            $filedocumento->refreshModificado();
        }
    }

}
