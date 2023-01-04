<?php

namespace App\Form;

use App\Entity\Subject;
use App\Entity\PlanningSubject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlanningType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('startdate')
            ->add('enddate')
            ->add('subject', EntityType::class, [
                'class' => Subject::class,
                'choice_label'=>'name'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PlanningSubject::class,
            'translation_domain'=> 'forms'
        ]);
    }
}
