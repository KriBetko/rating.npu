<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class YearType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('active', null, array(
                'label' => 'Активний?',
                'required' => false
            ))

            ->add('title', 'text', array(
                'label' => 'Назва'
            ))

            ->add('criteria', 'entity', array(
                'label' => "Список критеріїв",
                'class' => 'AppBundle:Criterion',
                'property' => 'title',
                'multiple' => true,
                'expanded' => true
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Year'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_year';
    }
}
