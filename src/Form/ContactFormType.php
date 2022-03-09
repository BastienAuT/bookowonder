<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Length(['min' => 6, "max" => 50]),
                    new NotBlank(),
                ],
            ])
            ->add('username', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('object', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('content', TextareaType::class, [
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
