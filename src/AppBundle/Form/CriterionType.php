<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CriterionType extends AbstractType
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
            ->add('coefficient', null, array(
                'label' => 'Коефіцієнт'
            ))
            ->add('reference', null, array(
                'required' => false,
                'label' => 'Опис'
            ))
            //->add('type')


            ->add('group', 'entity', array(
                'class' => 'AppBundle:Group',
                'property' => 'title',
                'label' => 'Групи критеріїв',
                'attr' => array(
                    'class' => 'form-control'
                ),
                'required'    => false,
                'placeholder' => 'Група критерїів',
                'empty_data'  => null
            ))
            ->add('category', 'entity', array(
                'class' => 'AppBundle:Category',
                'property' => 'title',
                'label' => 'Категрія',
                'attr' => array(
                    'class' => 'form-control'
                ),
                'required'    => true,
                'placeholder' => 'Категорія',
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
