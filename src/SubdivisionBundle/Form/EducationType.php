<?php

namespace SubdivisionBundle\Form;

use SubdivisionBundle\Entity\Job;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EducationType extends AbstractType
{
    public $job;

    /**
     * EducationType constructor.
     * @param Job $job
     */
    public function __construct($job)
    {
        $this->job = $job;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('institute', EntityType::class, array(
                'class' => 'SubdivisionBundle:Institute',
                'choice_label' => 'title',
                'label' => 'Факультет',
                'attr' => array(
                    'class' => 'form-control'
                ),
                'required' => true,
                'empty_data' => null
            ))
            ->add('formEducation', ChoiceType::class, array(
                'label' => 'Форма навчання',
                'choices' => $this->job->getFormList(),
                'required' => true,
                'empty_data' => null


            ))
            ->add('year', DateType::class, array(
                'years' => range(2008, date('Y')),
                'label' => 'Рік вступу',
                'widget' => 'choice',
                'months' => array(1),
                'days' => array(1)
            ))
            ->add('specialization', TextType::class, array(
                'label' => 'Спеціальність',
                'required' => false

            ))
            ->add('group', TextType::class, array(
                    'label' => 'Група',
                    'required' => false

                )
            );

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SubdivisionBundle\Entity\Job',
            'validation_groups' => array('education')
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'job';
    }
}
