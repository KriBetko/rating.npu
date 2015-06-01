<?php

namespace Rating\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->remove('username');
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
        ));
        $builder->add('plainPassword', 'repeated', array(
            'type' => 'password',
            'options' => array('translation_domain' => 'FOSUserBundle'),
            'first_options' => array('label' => 'Пароль', 'attr' => array(
                'class' => 'form-control'
            )),
            'second_options' => array('label' => 'Підтвердіть пароль', 'attr' => array(
                'class' => 'form-control'
            )),
            'invalid_message' => 'Паролі не співпадають',
        )
    );
    }

    public function getParent()
    {
        return 'fos_user_registration';
    }

    public function getName()
    {
        return 'rating_user_registration';
    }
}