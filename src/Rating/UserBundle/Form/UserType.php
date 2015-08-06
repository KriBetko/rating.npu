<?php

namespace Rating\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

         $builder->add('email', null, array(
             'attr' => array(
                 'class' => 'form-control'
             )
         ));
        $builder->add('firstName', null, array(
            'attr' => array(
                'class' => 'form-control'
            ),
            'label' => 'Прізвище'
        ));
        $builder->add('lastName', null, array(
            'attr' => array(
                'class' => 'form-control'
            ),
            'label' => "Ім'я"
        ));
        $builder->add('parentName', null, array(
            'attr' => array(
                'class' => 'form-control'
            ),
            'label' => 'По-батькові'
        ))
            ->add('email')
            ->add('birthday', 'date', array(
                'widget' => 'single_text',
                'label'  => 'Дата народження'
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rating\UserBundle\Entity\User',
            'validation_groups' => array('RatingProfile', 'RatingProfile')
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'rating_userbundle_user';
    }
}
