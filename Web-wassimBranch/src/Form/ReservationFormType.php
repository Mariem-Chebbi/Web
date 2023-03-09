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


class ReservationFormType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
        /*->add('idProduit', EntityType::class, [
            'class' => Product::class,
            'choice_label' => 'libelle',
            'choices' => $this->entityManager->getRepository(Product::class)->findAll(),
            
        ])*/
        ->add('idProduit',EntityType::class,[
            'label' => 'produit',
            'class' => Product::class,
            
            'choice_label' => 'libelle',
            'multiple' => true,
            'expanded' => true,
            
            
            ])    
        ->add('quantite',IntegerType::class,[
                'label' => 'quantite',
                'required' => true,
                //'data' => 1,
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
                'label' => 'dateReservation',
                'widget' => 'single_text',
                ])
            ->add('etat', ChoiceType::class, [
                'label' => 'etat',
                'attr' => ['placeholder' => 'etat du produit'],
                'choices' => [
                    'en cours' => 'en cours',
                    'traiter' => 'traiter',
                    'refuser' => 'refuser',
                ],
                
                ])
            ->add('Enregistrer', SubmitType::class)
        ;

        
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
    
    
}



