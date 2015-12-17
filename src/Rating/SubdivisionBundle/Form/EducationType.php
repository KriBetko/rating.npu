<?php

namespace Rating\SubdivisionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class EducationType extends AbstractType
{
    public $job;

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

            ->add('institute', 'entity', array(
                'class' => 'RatingSubdivisionBundle:Institute',
                'property' => 'title',
                'label' => 'Інститут',
                'attr' => array(
                    'class' => 'form-control'
                ),
                'required'    => true,
                'empty_data'  => null
            ))
            ->add('formEducation', 'choice', array(
                'label'     => 'Форма навчання',
                'choices'    => $this->job->getFormList(),
                'required'    => true,
                'empty_data'  => null


            ))
            ->add('entryYear', 'date', array(
                'years' => range(2008, date('Y')),
                'label' => 'Рік вступу',
                'widget'    => 'choice',
                'months'    => array(1),
                'days'      => array(1)
            ))
            ->add('specialization', 'text', array(
                'label'     => 'Спеціальність',
                'required'  => false

            ))
            ->add('group', 'text', array(
                    'label'     => 'Група',
                    'required'  => false

                )
            )
        ;

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rating\SubdivisionBundle\Entity\Job',
            'validation_groups' => array('education')
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'job';
    }
}
