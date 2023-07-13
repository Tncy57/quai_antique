<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $timeChoices = array_merge($options['timeRangeLunch'], $options['timeRangeDinner']);

        $builder
        ->add('date', DateType::class, [
          'input' => 'datetime_immutable',
          'widget' => 'single_text',
          'format' => 'yyyy-MM-dd',
          'attr' => ['min' => date('Y-m-d')],
        ])
        ->add('hour', ChoiceType::class, [
            'label' => 'Heure:',
            'choices' => $timeChoices,
            'attr' => [
                'id' => 'hour',
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired('timeRangeLunch');
        $resolver->setRequired('timeRangeDinner');
    }
}
