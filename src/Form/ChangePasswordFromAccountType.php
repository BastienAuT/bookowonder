<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordFromAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('old_password', PasswordType::class, [
            "label" => "Mon mot de passe",
            "mapped" => false,
            "attr" => [
                "placeholder" => "Veuillez saisir votre mot de passe actuel"
            ]
        ])
        ->add('new_password', PasswordType::class, [
            "mapped" => false,
            "label" => "Mon mot de passe",
            'constraints' => new Length(['min' => 8, "max" =>50]),
            "required" => true,
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
