<?php

namespace Rating\SubdivisionBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CathedraType extends AbstractType
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
            ->add('description', TextareaType::class, array(
                'label' => 'Короткий опис',
                'required' => false
            ))

            ->add('institute', EntityType::class, array(
                'class' => 'RatingSubdivisionBundle:Institute',
                'choice_label' => 'title',
                'label' => 'Институт'
            ))
            ->add('director', EntityType::class, array(
                'class' => 'RatingUserBundle:User',
                'label' => 'Директор',
                'required'    => false,
                'placeholder' => 'Директор',
                'empty_data'  => null
            ))

            ->add('managers', EntityType::class, array(
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
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rating\SubdivisionBundle\Entity\Cathedra'
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'rating_subdivisionbundle_cathedra';
    }
}
