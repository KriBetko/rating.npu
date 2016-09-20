<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
            ->add('editable', null, array(
                'label' => 'Дозволити редагування?',
                'required' => false
            ))
            ->add('title', TextType::class, array(
                'label' => 'Назва'
            ))

            ->add('criteria', EntityType::class, array(
                'label' => "Список критеріїв",
                'class' => 'AppBundle:Criterion',
                'choice_label' => 'title',
                'multiple' => true,
                'expanded' => true
            ))
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
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
