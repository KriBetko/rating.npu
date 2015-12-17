<?php

namespace Rating\SubdivisionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class JobType extends AbstractType
{
    public $instituteId;

    public function __construct($job)
    {
        $this->instituteId = ($job->getInstitute()) ? $job->getInstitute()->getId() : null;
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
                'placeholder' => 'Оберіть інститут',
                'empty_data'  => null
            ))


            ->add('cathedra', 'entity', array(
                'class' => 'RatingSubdivisionBundle:Cathedra',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.title', 'ASC');
                },
                'property' => 'title',
                'label' => 'Кафедра',
                'attr' => array(
                    'class' => 'form-control'
                ),
                'required'    => true,
                'placeholder' => 'Оберіть кафедру',
                'empty_data'  => null
            ))
            

            ->add('position', 'entity', array(
                'class' => 'RatingSubdivisionBundle:Position',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.title', 'ASC');
                },
                'property' => 'title',
                'label' => 'Посада',
                'attr' => array(
                    'class' => 'form-control'
                ),
                'required'    => true,
                'placeholder' => 'Оберіть посаду',
                'empty_data'  => null
            ))
            ->add('bet', 'number', array(
                'precision' => 2,
                'label'     => 'Ставка'

            ))
            ->add('additional', null, array(
                'label' => 'Сумісник'
            ));

    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rating\SubdivisionBundle\Entity\Job',
            'validation_groups' => array('addJob')
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
