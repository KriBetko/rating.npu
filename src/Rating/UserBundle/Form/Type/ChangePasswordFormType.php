<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rating\UserBundle\Form\Type;


use Rating\UserBundle\Form\Model\ChangePassword;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class ChangePasswordFormType extends AbstractType
{
    public $intention;

    public function __construct($intention = 'change_password')
    {
        $this->intention = $intention;

    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($this->intention !== 'reset'){

            $builder->add('current_password', 'password', array(
                'label' => 'Ваш поточний пароль',
                'translation_domain' => 'FOSUserBundle',
                'mapped' => false,
                'constraints' => new ChangePassword(),
            ));
        }

        $builder->add('plainPassword', 'repeated', array(
            'type' => 'password',
            'options' => array('translation_domain' => 'FOSUserBundle'),
            'first_options' => array('label' => 'Новий пароль'),
            'second_options' => array('label' => 'Повторіть новий пароль'),
            'invalid_message' => 'Паролі не співпадають',
            'constraints' => array(
                new NotBlank(array('message' => 'Заповніть поля')),
                new Length(array('min' => 4, 'minMessage' => 'Пароль має містити мінімум 4 символи!' )
            ),
        )));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'intention'  => 'change_password',
            "data_class" => "Rating\UserBundle\Entity\User"
        ));
    }

    public function getName()
    {
        return 'fos_user_change_password';
    }
}
