<?php

namespace Gopro\InventarioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ServicioType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('descripcion',null, array('label' => 'Descripción'))
            ->add('fecha',null,array(
                'input'  => 'datetime',
                'widget' => 'single_text',
                'attr' => array('class' => 'datePicker')
            ))
            ->add('item')
            ->add('serviciotipo',null, array('label' => 'Tipo'))
            ->add('servicioestado',null, array('label' => 'Estado'))
            ->add('user',null, array('label' => 'Ejecutor'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Gopro\InventarioBundle\Entity\Servicio'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gopro_inventariobundle_servicio';
    }
}
