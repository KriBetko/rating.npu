<?php

namespace Rating\SubdivisionBundle\Form;

use Doctrine\ORM\EntityManager;
use Rating\SubdivisionBundle\Entity\Job;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Validator\Constraints\Choice;

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

            ->add('years', 'entity', array(
                'class' => 'AppBundle\Entity\Year',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.id', 'ASC');
                },
                'property' => 'title',
                'label' => 'Рік',
                'attr' => array(
                    'class' => 'form-control'
                ),
                'mapped' => false,
                'required'    => true
            ))

            ->add('institute', 'entity', array(
                'class' => 'RatingSubdivisionBundle:Institute',
                'property' => 'title',
                'label' => 'Факультет',
                'attr' => array(
                    'class' => 'form-control'
                ),
                'required'    => false,
                'placeholder' => 'Оберіть факультет(інститут)',
                'empty_data'  => null
            ))

            ->add('formEducation', 'choice', array(
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

            ->add('group', 'choice', array(
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
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rating\SubdivisionBundle\Entity\Job'
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
