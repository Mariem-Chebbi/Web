<?php

namespace App\Form;

use App\Entity\Blog;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityManagerInterface;



class BlogFormType extends AbstractType
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('libelle',TextType::class,[
                'label' => 'Label',
                'attr' => ['placeholder' => 'Label du produit']
                
                ])
            ->add('idCategorie',EntityType::class,[
                'label' => 'categorie',
                'class' => Categorie::class,
                
                'choice_label' => 'Libelle',
                'multiple' => true,
                'expanded' => true,
                
                
                ])    
            ->add('description',TextareaType::class,[
                'label' => 'Description',
                'attr' => ['placeholder' => 'Description du produit']
                ])
            ->add('date',DateType::class,[
                'label' => 'date',
                'widget' => 'single_text',
                ])
            ->add('auteur',TextType::class,[
                'label' => 'Auteur',
                'attr' => ['placeholder' => ' auteur du blog']
                
                ])
            ->add('image', FileType::class, [
                'label' => 'File',
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
            ->add('Enregistrer', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Blog::class,
        ]);
    }
}
