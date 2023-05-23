<?php

namespace App\Form;

use App\Entity\Schedule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class ScheduleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('day', TextType::class)
            ->add('date', DateType::class, [
                'input' => 'datetime_immutable',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => ['min' => date('Y-m-d')],
            ])
            ->add('lunchOpening', TimeType::class, [
                'input' => 'datetime_immutable',
                'widget' => 'choice',
            ])
            ->add('lunchClosing', TimeType::class, [
                'input' => 'datetime_immutable',
                'widget' => 'choice',
            ])
            ->add('dinnerOpening', TimeType::class, [
              'input' => 'datetime_immutable',
              'widget' => 'choice',
            ])
            ->add('dinnerClosing', TimeType::class, [
              'input' => 'datetime_immutable',
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
