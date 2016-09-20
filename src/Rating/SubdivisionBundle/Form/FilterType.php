<?php

namespace Rating\SubdivisionBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterType extends AbstractType
{
    public $instituteId;

    public function __construct()
    {

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
                'placeholder' => 'Оберіть факультет(інститут)',
                'empty_data'  => null
            ))


            ->add('cathedra', EntityType::class, array(
                'class' => 'RatingSubdivisionBundle:Cathedra',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.title', 'ASC');
                },
                'choice_label' => 'title',
                'label' => 'Кафедра',
                'attr' => array(
                    'class' => 'form-control'
                ),
                'required'    => false,
                'placeholder' => 'Оберіть кафедру',
                'empty_data'  => null
            ))
            

            ->add('position', EntityType::class, array(
                'class' => 'RatingSubdivisionBundle:Position',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.title', 'ASC');
                },
                'choice_label' => 'title',
                'label' => 'Посада',
                'attr' => array(
                    'class' => 'form-control'
                ),
                'required'    => false,
                'placeholder' => 'Оберіть посаду',
                'empty_data'  => null
            ))

            ->add('additional', null, array(
                'label' => 'Рейтинг з сумісниками'
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
    public function getName()
    {
        return 'job';
    }
}
