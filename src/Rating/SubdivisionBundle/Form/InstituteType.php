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
                'label' => 'Короткий опис',
                'required' => false
            ))
            ->add('director', 'entity', array(
                'class' => 'RatingUserBundle:User',
                'label' => 'Директор',
                'required'    => false,
                'placeholder' => 'Директор',
                'empty_data'  => null
            ))

            ->add('managers', 'entity', array(
                'class' => 'RatingUserBundle:User',
                'label' => 'Керівники',
                'empty_value' => null,
                'empty_data' => null,
                'multiple' =>true,
                'required'    => false,
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
