<?php

namespace App\Form;

use App\Entity\Centre;
use App\Entity\Services;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CentreFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Nom_social')
            ->add('Aderesse',TextType::class,[
                'label' => 'Adresse',
               
                
                ])
            ->add('Ville',ChoiceType::class, [
                'label' => 'Ville',
                'attr' => ['placeholder' => 'ville'],
                'choices' => [
                    'Tunis' => 'Tunis',
                    'Ariana' => 'Ariana',
                    'Sfax' => 'Sfax',
                    'Sousse' => 'Sousse',
                    'Kairouan' => 'Kairouan',
                    'Bizerte' => 'Bizerte',
                    'Beja' => 'Beja',
                    'Kebili' => 'Kebili',
                    'Le Kef' => 'Le Kef',
                    'Mounastir' => 'Mounastir',
                    'Manouba' => 'Manouba',],])
                
            ->add('Logo', FileType::class, [
                'label' => 'Logo',
                'attr' => ['class' => 'dropzone',
                
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger un fichier valide (jpeg, png).',
                    ]),
                ],
                ])
            ->add('Tel1')
            ->add('Tel2')
            ->add('Description')
            ->add('idServices',EntityType::class,[
                'label' => 'Service',
                'class' => Services::class,
                
                'choice_label' => 'libelle',
                'multiple' => true,
                'expanded' => true,
                
                
                ])    
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Centre::class,
        ]);
    }
}