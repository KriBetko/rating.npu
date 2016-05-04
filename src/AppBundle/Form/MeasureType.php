<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use AppBundle\Form\FieldType;

class MeasureType extends AbstractType
{
    public $measure;
    public function __construct($measure)
    {
        $this->measure  =   $measure->getCriterion();
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($this->measure->isPlural()){
            $builder->add('value', 'integer', array(
                'label' => false
            ));
        } else {
            $builder->add('value', 'checkbox', array(
                'label' => $this->measure->getTitle(),
                'required'  => false,

            ));

            $builder->get('value')
                ->addModelTransformer(new CallbackTransformer(
                    function ($originalDescription) {
                        return $originalDescription === 1 ? true : false;
                    },
                    function ($submittedDescription) {
                        return $submittedDescription === true ? 1 : 0;
                    }
                ))
            ;
        }
        $builder->add('fields', 'collection', array(
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
