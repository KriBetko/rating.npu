<?php

namespace SubdivisionBundle\Form;

use Doctrine\ORM\EntityRepository;
use SubdivisionBundle\Entity\Job;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JobType extends AbstractType
{
    public $instituteId;

    /**
     * @param Job $job
     */
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
            ->add('institute', EntityType::class, array(
                'class' => 'SubdivisionBundle:Institute',
                'choice_label' => 'title',
                'label' => 'Факультет',
                'attr' => array(
                    'class' => 'form-control'
                ),
                'required' => true,
                'placeholder' => 'Оберіть факультет',
                'empty_data' => null
            ))
            ->add('cathedra', EntityType::class, array(
                'class' => 'SubdivisionBundle:Cathedra',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.title', 'ASC');
                },
                'choice_label' => 'title',
                'label' => 'Кафедра',
                'attr' => array(
                    'class' => 'form-control'
                ),
                'required' => true,
                'placeholder' => 'Оберіть кафедру',
                'empty_data' => null
            ))
            ->add('position', EntityType::class, array(
                'class' => 'SubdivisionBundle:Position',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.title', 'ASC');
                },
                'choice_label' => 'title',
                'label' => 'Посада',
                'attr' => array(
                    'class' => 'form-control'
                ),
                'required' => true,
                'placeholder' => 'Оберіть посаду',
                'empty_data' => null
            ))
            ->add('bet', NumberType::class, array(
                'scale' => 2,
                'label' => 'Ставка'

            ))
            ->add('additional', null, array(
                'label' => 'Сумісник'
            ));

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SubdivisionBundle\Entity\Job',
            'validation_groups' => array('addJob')
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
