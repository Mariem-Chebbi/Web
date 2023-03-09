<?php

namespace App\Form;

use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Gregwar\CaptchaBundle\Type\CaptchaType;



class FormationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('libelle',TextType::class,[
                'label' => 'Label',
                'attr' => ['placeholder' => 'Label du formation',
                'class' => 'form-control',
                ]
                
                ])
            ->add('description',TextareaType::class,[
                'label' => 'Description',
                'attr' => ['placeholder' => 'Description du formation',
                'class' => 'form-control',
                ]
                ])
                ->add('dateFormation',DateType::class,[
                    'label' => 'date Formation',
                    'widget' => 'single_text',
                    'attr' => ['class' => 'form-control',
                    'placeholder' => date('Y-m-d' , time()),                       
            ],
                    ])
            ->add('image', FileType::class, [
                'label' => 'File',
                'attr' => ['class' => 'dropzone',               
                // ],
                // 'constraints' => [
                //     new File([     
                //         'mimeTypes' => [
                //             'image/jpeg',
                //             'image/png',
                //         ],
                //         'mimeTypesMessage' => 'Veuillez télécharger un fichier valide (jpeg, png).',
                //     ]),
                // ],
                ]])
            ->add('Enregistrer', SubmitType::class,[               
            ])
            // ->add('captcha', CaptchaType::class,[
            //     'label' => 'Enregistrer'
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,
        ]);
    }
}
