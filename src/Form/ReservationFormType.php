<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class ReservationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'constraints' => [
                  new notBlank([
                    'message' => 'Votre prenom',
                  ])
                ]
            ])
            ->add('lastname')
            ->add('email')
            ->add('date', DateType::class, [
                'input' => 'datetime_immutable',
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => [
                  'id' => 'date',
                  'min' => date('Y-m-d')
                ],
            ])
            ->add('hour', TimeType::class, [
                'label' => 'Heure',
                'label_attr' => ['id' => 'my-label-id'],
                'input' => 'datetime_immutable',
                'widget' => 'choice',
                'hours'   => [12, 13, 19, 20],
                'minutes' => [00, 15, 30, 45],
                'required' => true,
            ])
            ->add('numberOfGuests', IntegerType::class, [
                'attr' => ['min' => 2, 'max' => 6],
            ])
            ->add('allergy', TextType::class, [
                'label' => 'Allergie',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);      
    }
}