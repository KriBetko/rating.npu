<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

         $builder->add('email', TextType::class, array(
             'disabled' => true,
             'attr' => array(
                 'class' => 'form-control',
                 'disabled' => true,


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

            ->add('birthday', DateType::class, array(
                'widget' => 'single_text',
                'label'  => 'Дата народження'
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\User',
            'validation_groups' => array('Profile', 'Profile')
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'userbundle_user';
    }
}
