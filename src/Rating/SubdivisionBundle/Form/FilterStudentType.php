<?php

namespace Rating\SubdivisionBundle\Form;

use Doctrine\ORM\EntityManager;
use Rating\SubdivisionBundle\Entity\Job;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class FilterStudentType extends AbstractType
{
    public $instituteId;
    public $em;

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('years', EntityType::class, array(
                'class' => 'AppBundle\Entity\Year',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.id', 'ASC');
                },
                'choice_label' => 'title',
                'label' => 'Рік',
                'attr' => array(
                    'class' => 'form-control'
                ),
                'mapped' => false,
                'required'    => true
            ))

            ->add('institute', EntityType::class, array(
                'class' => 'RatingSubdivisionBundle:Institute',
                'choice_label' => 'title',
                'label' => 'Факультет',
                'attr' => array(
                    'class' => 'form-control'
                ),
                'required'    => false,
                'placeholder' => 'Оберіть факультет',
                'empty_data'  => null
            ))

            ->add('formEducation', ChoiceType::class, array(
                'choices' => Job::$fList,
                'empty_value' => 'Не обрано',
                'label' => 'Форма навчання',
                'attr' => array(
                    'class' => 'form-control'
                ),
                'required'    => false,
                'placeholder' => 'Форма навчання',
                'empty_data'  => null,

            ))

            ->add('group', ChoiceType::class, array(
                'choices' =>
                    $this->em->getRepository('RatingSubdivisionBundle:Job')->getGroupList()
                ,
                'empty_value' => 'Не обрано',
                'choices_as_values' => false,
                'label' => 'Група',
                'required' => false
            ))
          ;

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rating\SubdivisionBundle\Entity\Job'
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
