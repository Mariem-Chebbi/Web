<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\TelType;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',TextType::class,[
                'attr' => ['class' => 'form-control',
                    
        ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
                
            ])
          
            // ...
            ->add('Password', PasswordType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 8, 'max' => 4096]),
                ],
            ])
            // ...
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'user' => 'ROLE_USER',
                    'personnel' => 'ROLE_PERSONNEL',
                    'super admin' => 'ROLE_SUPERADMIN',
                    'super client' => 'ROLE_CLIENT',


                ],
                'multiple' => true,
                'expanded' => true,
                'attr' => [
                'class' => 'roles-inline', // add a custom CSS class
                ],
            ])
               
            
        
                ->add('image', FileType::class, [
                    'label' => 'File',
                    'attr' => ['class' => 'dropzone',
                    'class' => 'form-control',
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
            ->add('ville',TextType::class,[
                'attr' => ['class' => 'form-control',
                    
                    ],
            ])
            ->add('nom',TextType::class,[
                'attr' => ['class' => 'form-control',
                    
                    ],
            ])
            ->add('prenom',TextType::class,[
                'attr' => ['class' => 'form-control',
                    
                    ],
            ])
            ->add('num_tel', TelType::class, [
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            ->add('date_naissance', BirthdayType::class, [
                'label' => 'Date de naissance'
                ],
            )
           

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
