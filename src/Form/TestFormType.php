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
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class TestFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $timeChoices = array_merge($options['timeRangeLunch'], $options['timeRangeDinner']);

        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();

            // Seçilen saat değerini dönüştürme işlemini yapalım
            $hour = new \DateTime($data['hour']);

            // Dönüştürülen saat değerini form verisine geri yükleyelim
            $data['hour'] = $hour;
            $event->setData($data);
        })
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
        ->add('hour', ChoiceType::class, [
          'label' => 'Heure',
          'label_attr' => ['id' => 'my-label-id'],
          'choices'   => $timeChoices,
          'required' => true,
        ])
        ->add('numberOfGuests', IntegerType::class, [
            'attr' => ['min' => 1],
        ])
        ->add('allergy', TextType::class, [
            'label' => 'Allergie',
            'required' => false,
        ])
       ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setRequired('timeRangeLunch');
        $resolver->setRequired('timeRangeDinner');
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);      
    }
}