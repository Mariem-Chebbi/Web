<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Reservation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Form\ChoiceList\Loader\ChoiceLoaderInterface;

class ReservationFrontFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('quantite',IntegerType::class,[
            'label' => 'Quantité',
            'required' => true,
            //'data' => 1,
            'attr' => [
                'class' => 'form-control',
                
            ],
            'constraints' => [
                new Range([
                    'min' => 1,
                    'max' => 100,
                    'minMessage' => 'La valeur doit être supérieure ou égale à 1',
                    'maxMessage' => 'La valeur doit être inférieure ou égale à {{ limit }}',
                ]),
            ],
            ])
        ->add('dateReservation',DateType::class,[
            'label' => 'Date de Reservation',
            'widget' => 'single_text',
            'attr' => [
                'class' => 'form-control',
                'style' => 'background-color: #f8f9fa; border-color: #f8f9fa;',
                
            ],
            ])
            ->add('Enregistrer', SubmitType::class, [
                'attr' => [
                    'class' => 'form-control',
                    
                ],  

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
