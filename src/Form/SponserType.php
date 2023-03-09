<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\Sponser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class SponserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom_sponser',TextType::class,[
                'label' => 'Nom Sponsor',
                'attr' => ['placeholder' => 'nom du sponsor',
                'class' => 'form-control'
                ]
                
                ])
            ->add('Type',TextType::class,[
                'label' => 'Type Sponsor',
                'attr' => ['placeholder' => 'type sponsor',
                'class' => 'form-control'
                ]
                
                ])
            ->add(
                'evenement',EntityType::class,
                [    'label' =>'Evenement',
                    'class' => Evenement::class,
                    'choice_label' => 'nom_event',
                    //'multiple' => false,
                   // 'expanded' => false,
                   'attr' => ['class'=> 'form-control',],
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sponser::class,
        ]);
    }
}
