<?php

namespace Trejdl\EmployeeBundle\Form;

use Doctrine\ORM\EntityRepository;
use Trejdl\EmployeeBundle\Entity\Employee;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('email', EmailType::class)
            ->add('phone', NumberType::class)
            ->add('web', UrlType::class, array(
                'required'   => false))
            ->add('room', TextType::class)
            ->add('roles', EntityType::class, array(
                'class' => 'TrejdlEmployeeBundle:Role',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('r')
                        ->where('r.isVisible = ?1')
                        ->setParameter(1, true);
                },
                'choice_label' => 'description',
                'multiple' => 'true',
                'expanded' => 'true',

            ))
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Employee::class
        ));
    }
}
