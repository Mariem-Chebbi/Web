<?php

namespace App\Form;

use App\Entity\Evenement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_event',TextType::class,[
                'label' => 'Nom Evenement',
                'attr' => ['placeholder' => 'nom evenement',
                'class' => 'form-control'
                ]
                
                ])
            ->add('Lieu_event',TextType::class,[
                'label' => 'Lieu Evenement',
                'attr' => ['placeholder' => 'lieu evenement',
                'class' => 'form-control'
                ]
                
                ])
            ->add('Description',TextareaType::class,[
                'label' => 'Description',
                'attr' => ['placeholder' => 'Description',
                'class' => 'form-control'
                ]
                
                ])
            ->add('Date_debut',DateType::class,[
                'label' => 'Date Debut Evenement',
                'attr' => ['placeholder' => 'date debut event',
                'class' => 'form-control'
                ]
                
                ])
            ->add('Date_fin',DateType::class,[
                'label' => 'Date fin Evenement',
                'attr' => ['placeholder' => 'date fin  event',
                'class' => 'form-control'
                ]
                
                ])
         
                
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
