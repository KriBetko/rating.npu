<?php

namespace AppBundle\Form;

use AppBundle\Entity\Group;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CriterionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'label' => 'Назва'
            ))
            ->add('coefficient', null, array(
                'label' => 'Коефіцієнт'
            ))
            ->add('reference', null, array(
                'required' => false,
                'label' => 'Опис'
            ))



            ->add('group', EntityType::class, array(
                'class' => 'AppBundle:Group',
                'choice_label' => 'title',
                'label' => 'Групи критеріїв',
                'attr' => array(
                    'class' => 'form-control'
                ),
                'required'    => false,
                'placeholder' => 'Група критерїів',
                'empty_data'  => null
            ))
            ->add('category', EntityType::class, array(
                'class' => 'AppBundle:Category',
                'choice_label' => 'title',
                'label' => 'Категрія',
                'attr' => array(
                    'class' => 'form-control'
                ),
                'required'    => true,
                'placeholder' => 'Категорія',
                'empty_data'  => null
            ))
            ->add('plural', ChoiceType::class, array(
                'label' => 'Тип',
                'choices'   => array(
                    Group::T_PLURAL => 'Множинний',
                    Group::T_UNITARY => 'Одиничний',
                )
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Criterion'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_criterion';
    }
}
