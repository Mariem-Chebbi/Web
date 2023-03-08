<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;


class UserFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
       
        
        ->add('email')
        ->add('roles', ChoiceType::class, [
            'choices' => [
                'user' => 'ROLE_USER',
                'personnel' => 'ROLE_PERSONNEL',
                'super admin' => 'ROLE_SUPERADMIN',

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
        ->add('ville')
        ->add('password')

        ->add('nom')
        ->add('prenom')
        ->add('num_tel')
        ->add('date_naissance')
        ->add('save',SubmitType::class)

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
