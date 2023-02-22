<?php

namespace App\Form;

use App\Entity\Test;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',
                'attr' => [
                    'class' => 'datepicker',
                ],
            ])
            ->add('time', TimeType::class, [
                'widget' => 'choice',
                'minutes' => [0, 15, 30, 45], // set available minutes
            ])
            ->add('submit', SubmitType::class);

        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();
            //$date = $form->get('date')->getData();
            // Check if the form data contains a 'start_date' field
            if ($data->getdate()) {
                //die("hello");
                //dd($event);
                // Modify the 'end_date' field to use the same date format as the 'start_date' field
                $form->add('time', TimeType::class, [
                    'widget' => 'choice',
                    'minutes' => [10, 13],
                ]);
            } else {
                $form->add('time', TimeType::class, [
                    'widget' => 'choice',
                    'minutes' => [0, 15, 30, 45], // set available minutes
                ]);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Test::class,
        ]);
    }
}
