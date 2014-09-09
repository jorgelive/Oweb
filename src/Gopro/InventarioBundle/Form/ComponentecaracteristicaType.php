<?php

namespace Gopro\InventarioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Gopro\InventarioBundle\Form\EventListener\ComponentecaracteristicaCamposSubscriber;

class ComponentecaracteristicaType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('contenido')
            ->add('caracteristica',null, array('label' => 'Característica'))
            ->addEventSubscriber(new ComponentecaracteristicaCamposSubscriber());
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gopro\InventarioBundle\Entity\Componentecaracteristica'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gopro_inventariobundle_componentecaracteristica';
    }
}
