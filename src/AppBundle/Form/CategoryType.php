<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CategoryType extends AbstractType
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
            ->add('type', 'choice', array(
                'choices'  => array(
                    1 => 'Для викладачів',
                    2 => 'Для студентів',
                    3 => 'Для кафедри',
                    4 => 'Для інститута'
                ),
                'required' => false,

                'attr' => array(
                    'class' => 'form-control'
                ),
                'placeholder' => 'Тип',
                'empty_data'  => null
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Category'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_category';
    }
}
