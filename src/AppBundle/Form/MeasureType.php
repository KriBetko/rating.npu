<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Form\FieldType;

class MeasureType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value', 'integer', array(
                'label' => false
            ))
            ->add('fields', 'collection', array(
                'type' => new FieldType(),
                    'label' =>false,
                    'allow_add'    => true,
                    'by_reference' => false,
                    'allow_delete' => true
                )
            );
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Measure'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'measure';
    }
}
