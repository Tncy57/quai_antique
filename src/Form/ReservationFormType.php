<?php

namespace App\Form;

use App\Entity\Reservation;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\NotBlank;

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
            ->add('date', DateTimeType::class)
            ->add('numberOfGuests', IntegerType::class, [
                'attr' => ['min' => 0],
            ])
            ->add('allergy')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
