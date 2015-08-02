<?php

namespace Rating\SubdivisionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CathedraType extends AbstractType
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

            ->add('institute', 'entity', array(
                'class' => 'RatingSubdivisionBundle:Institute',
                'property' => 'title',
                'label' => 'Институт'
            ));
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rating\SubdivisionBundle\Entity\Cathedra'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'rating_subdivisionbundle_cathedra';
    }
}
