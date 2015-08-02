<?php

namespace Rating\SubdivisionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class InstituteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array(
                'label' => 'Назва'
            ))
            ->add('description', 'textarea', array(
                'label' => 'Короткий опис'
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rating\SubdivisionBundle\Entity\Institute'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'rating_subdivisionbundle_institute';
    }
}
