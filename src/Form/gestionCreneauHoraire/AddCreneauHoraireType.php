<?php

namespace App\Form;

use App\Entity\CreneauHoraire;
use App\Repository\CreneauHoraireRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddCreneauHoraireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add(
            //     'creneauHoraire',
            //     ChoiceType::class,
            //     [
            //         //'class' => CreneauHoraire::class,
            //         //'mapped' => false,
            //         'choices' => function (CreneauHoraireRepository $repository) {
            //             $days = ["Lundi" => "Lundi", "Mardi" => "Mardi", "Mercredi" => "Mercredi", "Jeudi" => "Jeudi", "Vendredi" => "Vendredi", "Samedi" => "Samedi", "Dimanche" => "Dimanche"];
            //             foreach ($repository->findActiveEtat() as $key => $value) {
            //                 if (in_array($value, array_values($days))) {
            //                     unset($days[$key]);
            //                 }
            //             }
            //             return $days;
            //         },
            //         //'choice_label' => 'jour',
            //         'expanded' => false,
            //         'multiple' => false,
            //         'required' => true,
            //         'attr' => [
            //             'class' => 'form-control',
            //             'style' => 'font-size: 16px;',
            //         ],
            //     ]
            // )
            ->add(
                'jour',
                TextType::class,
                [
                    'attr' => [
                        'class' => 'form-control',
                        'style' => 'color: blue; font-size: 16px;',
                    ],
                ]
            )
            ->add('heureDebut', ChoiceType::class, [
                'choices' => [
                    '00' => 0,
                    '01' => 1,
                    '02' => 2,
                    '03' => 3,
                    '04' => 4,
                    '05' => 5,
                    '06' => 6,
                    '07' => 7,
                    '08' => 8,
                    '09' => 9,
                    '10' => 10,
                    '11' => 11,
                    '12' => 12,
                    '13' => 13,
                    '14' => 14,
                    '15' => 15,
                    '16' => 16,
                    '17' => 17,
                    '18' => 18,
                    '19' => 19,
                    '20' => 20,
                    '21' => 21,
                    '22' => 22,
                    '23' => 23,
                ],
                'expanded' => false,
                'multiple' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'color: blue; font-size: 16px;',
                ],

            ])
            ->add('heureFin', ChoiceType::class, [
                'choices' => [
                    '00' => 0,
                    '01' => 1,
                    '02' => 2,
                    '03' => 3,
                    '04' => 4,
                    '05' => 5,
                    '06' => 6,
                    '07' => 7,
                    '08' => 8,
                    '09' => 9,
                    '10' => 10,
                    '11' => 11,
                    '12' => 12,
                    '13' => 13,
                    '14' => 14,
                    '15' => 15,
                    '16' => 16,
                    '17' => 17,
                    '18' => 18,
                    '19' => 19,
                    '20' => 20,
                    '21' => 21,
                    '22' => 22,
                    '23' => 23,
                ],
                'expanded' => false,
                'multiple' => false,
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                    'style' => 'color: blue; font-size: 16px;',
                ],

            ])
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
                        'class' => 'btn btn-dark main-gradient-button',
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
