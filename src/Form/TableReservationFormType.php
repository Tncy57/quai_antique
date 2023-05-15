<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class TableReservationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Retrieve opening and closing hours from your database or configuration
        $lunchOpeningHour = '12:00';
        $lunchClosingHour = '15:00';
        $eveningOpeningHour = '19:00';
        $eveningClosingHour = '22:00';

        $choices = [];

        // Generate lunchtime time slots
        $lunchCurrentTime = \DateTime::createFromFormat('H:i', $lunchOpeningHour);
        $lunchClosingTime = \DateTime::createFromFormat('H:i', $lunchClosingHour);
        $lunchInterval = new \DateInterval('PT15M');

        while ($lunchCurrentTime < $lunchClosingTime && $lunchCurrentTime <= \DateTime::createFromFormat('H:i', '14:00')) {
            $choices['LUNCH'][$lunchCurrentTime->format('H:i')] = $lunchCurrentTime->format('H:i');
            $lunchCurrentTime->add($lunchInterval);
        }

        // Generate evening time slots
        $eveningCurrentTime = \DateTime::createFromFormat('H:i', $eveningOpeningHour);
        $eveningClosingTime = \DateTime::createFromFormat('H:i', $eveningClosingHour);
        $eveningInterval = new \DateInterval('PT15M');
    
        while ($eveningCurrentTime < $eveningClosingTime && $eveningCurrentTime <= \DateTime::createFromFormat('H:i', '21:00')) {
            $choices['EVENING'][$eveningCurrentTime->format('H:i')] = $eveningCurrentTime->format('H:i');
            $eveningCurrentTime->add($eveningInterval);
        }

        $builder
            ->add('numberOfGuests', IntegerType::class, [
                'label' => 'Number of Guests',
            ])
            ->add('date', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('time', ChoiceType::class, [
                'choices' => $choices,
                'label' => 'Time',
            ])
            ->add('allergies', TextType::class, [
                'required' => false,
            ]);
    }
}