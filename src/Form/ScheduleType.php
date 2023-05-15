<?php

namespace App\Form;

use App\Entity\Schedule;
use DateTime;
use Symfony\Component\Form\AbstractType;
#use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScheduleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('day')
            ->add('lunchOpening', DateTime::class, [
                'label' => 'Lunch Opening',
                'input' => 'datetime',
                'widget' => 'choice',
            ])
            ->add('lunchClosing', DateTime::class, [
                'label' => 'Lunch Closing',
                'input' => 'datetime',
                'widget' => 'choice',
            ])
            ->add('dinnerOpening', DateTime::class, [
                'label' => 'Dinner Opening',
                'input' => 'datetime',
                'widget' => 'choice',
            ])
            ->add('dinnerClosing', DateTime::class, [
                'label' => 'Dinner Closing',
                'input' => 'datetime',
                'widget' => 'choice',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Schedule::class,
        ]);
    }
}
