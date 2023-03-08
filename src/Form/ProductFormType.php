<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;




class ProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle',TextType::class,[
                'label' => 'Label',
                'attr' => ['placeholder' => 'Label du produit',
                'class' => 'form-control'
                ]
                
                ])
            ->add('description',TextareaType::class,[
                'label' => 'Description',
                'attr' => ['placeholder' => 'Description du produit',
                'class' => 'form-control'
                ]
                ])
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
                            'minMessage' => 'La valeur doit être supérieure ou égale à 1',
                           
                        ]),
                    ],
                    ])
            ->add('image', FileType::class, [
                'label' => 'Image',
                'attr' => ['class' => 'dropzone',
                //'class' => 'form-control'
                
                ],
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
            'data_class' => Product::class,
        ]);
    }
}
