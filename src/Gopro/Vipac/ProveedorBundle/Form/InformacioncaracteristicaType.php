<?php

namespace Gopro\Vipac\ProveedorBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Gopro\Vipac\ProveedorBundle\Form\EventListener\AgregarInformacioncaracteristicaInformacionSubscriber;

class InformacioncaracteristicaType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('caracteristica')
            ->add('contenido')
            ->addEventSubscriber(new AgregarInformacioncaracteristicaInformacionSubscriber());
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gopro\Vipac\ProveedorBundle\Entity\Informacioncaracteristica'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gopro_vipac_proveedorbundle_informacionadjunto';
    }
}