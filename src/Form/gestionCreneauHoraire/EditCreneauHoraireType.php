<?php

namespace App\Form;

use App\Entity\CreneauHoraire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditCreneauHoraireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'heureDebut',
                NumberType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                    ],
                ]
            )
            ->add(
                'heureFin',
                NumberType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                    ],
                ]
            )
            ->add('etat', null, [
                'attr' => [
                    'class' => 'form-check-input',
                    'style' => 'margin-left: 8px'
                ],
            ])
            ->add(
                'Valider',
                SubmitType::class,
                [
                    'attr' => [
                        'class' => 'btn btn-dark',
                        'id' => 'form-submit'
                    ],

                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CreneauHoraire::class,
        ]);
    }
}
