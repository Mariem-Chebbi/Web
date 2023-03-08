<?php

namespace App\Form;

use App\Entity\Certification;
use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;

class CertificationFormType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('image', FileType::class, [
            'label' => 'File',
            'attr' => ['class' => 'dropzone',
            
            
            // ],
            // 'constraints' => [
            //     new File([
            //         'maxSize' => '1024k',
            //         'mimeTypes' => [
            //             'image/jpeg',
            //             'image/png',
            //         ],
            //         'mimeTypesMessage' => 'Veuillez télécharger un fichier valide (jpeg, png).',
            //     ]),
            // ],
            ]])
            ->add('dateCertif',DateType::class,[
                'label' => 'date certification',
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control',
                'placeholder' => date('Y-m-d' , time()),
            
            
            ],
                ])
            ->add('idFormation',EntityType::class,[
                'label' => 'Formation',
                'class' => Formation::class,
                
                'choice_label' => 'libelle',
                //'multiple' => true,
                //'expanded' => true,
                'attr' => ['class' => 'form-control',
            
            
            ],
                
                ])
                ->add('Enregistrer', SubmitType::class,[
                     ]) 
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Certification::class,
        ]);
    }
}
