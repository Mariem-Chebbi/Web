<?php

namespace App\Form;

use App\Entity\RendezVous;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RendezVousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('id_personnel', EntityType::class, [
                'class' => User::class,
                'choice_label' => function (User $user) {
                    return $user->getNom() . " " . $user->getPrenom();
                },
                'attr' => [
                    'class' => 'form-control',
                ],
                'placeholder' => 'Choisir un personnel',
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('date_rdv', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => [
                    'class' => 'datepicker form-control',
                ]
            ])
            ->add(
                'Ok',
                SubmitType::class,
                [
                    'attr' => [
                        'class' => 'btn btn-dark px-4',
                        'id' => 'form-submit'
                    ],
                ]
            );;
        // ->add('heure', TimeType::class, [
        //     'widget' => 'single_text',
        // ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RendezVous::class,
        ]);
    }
}
