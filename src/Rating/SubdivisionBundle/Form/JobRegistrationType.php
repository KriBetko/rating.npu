<?php

namespace Rating\SubdivisionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class JobRegistrationType extends AbstractType
{
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
            'label' => 'Институт',
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
        ));
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
        return 'registration_job';
    }
}
