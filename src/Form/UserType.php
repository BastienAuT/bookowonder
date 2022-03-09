<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => "Email pour l'utilisateur",
                'constraints' => new Length(['min' => 6, "max" =>50]),
                "attr" => [
                    "placeholder" => "Exemple : gerardbouchard@mail.com"
                ]
            ])
            ->add('roles', ChoiceType::class, [
                // Finalement on met le multiple à false
                // Mais pour que ça marche, on a besoin d'un DataTransformer
                'multiple' => false,
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'Utilisateur' => 'ROLE_USER',
                ],
                'expanded' => true, // On veut des checkboxes, c'est plus user friendly
            ])
            ->add('password', RepeatedType::class, [
                "type" => PasswordType::class,
                "invalid_message" => "Le mot de passe et la confirmation doivent être identiques",
                "label" => "Votre mot de passe",
                'constraints' => new Length(['min' => 7, "max" =>50]),
                "required" => false, //false because we don't want the obligation to reset a password on edition of a User
                "first_options" => ["label" => "Mot de passe pour l'utilisateur", "attr" => [ "placeholder" => "motdepasse"]],
                "second_options" => ["label" => "Confirmez le mot de passe", "attr" => [ "placeholder" => "motdepasse"]],
                'mapped' => false
            ])
            ->add('name', TextType::class, [
                "label" => "Nom d'affichage de l'utilisateur",
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('profilePic', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Insérer une image valide',
                    ])
                ]
            ])
            // Adding of an event listener who fire before filling datas in $form fields
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                // like all programmation with events, $event has all infos on event
                // we can retrieve informations of the form and entity whit $event
                $user = $event->getData();
                $form = $event->getForm();

                // if $user exists ( edit mode ) =>  required : false
                // else ( add mode ) => required : true
                // it is not possible to modify and existing field :'(
                // but we can delete it and recreate it !

                //if user id is empty, we have to create a user

                if ($user->getId() == null){
                    $form->remove('password');

                    $form->add('password', RepeatedType::class, [
                        "type" => PasswordType::class,
                        "invalid_message" => "Le mot de passe et la confirmation doivent être identiques",
                        "label" => "Votre mot de passe",
                        'constraints' => new Length(['min' => 7, "max" =>50]),
                        "required" => true, // because user don't exist yet ! So the password is required
                        "first_options" => ["label" => "Mot de passe pour l'utilisateur", "attr" => [ "placeholder" => "motdepasse"]],
                        "second_options" => ["label" => "Confirmez le mot de passe", "attr" => [ "placeholder" => "motdepasse"]],
                        "constraints" => [
                            new NotBlank()
                        ],
                        "mapped" => false
                    ]);
                    }

            })
            
        ;

        $builder->get('roles')->addModelTransformer(new CallbackTransformer(
            // La fonction qui prend la donnée dans l'entité et la transforme dans le type du form
            function ($tagsAsArray) {
                // transform the array to a string
                // Même si getRoles() ajoute toujours ROLE_USER, on ne conserve que le premier role de l'utilisateur
                return $tagsAsArray[0];
            },
            // La fonction qui prend la donnée du form et la transforme pour être compatible avec l'entité
            function ($tagsAsString) {
                // transform the string back to an array
                // Le ChoiceType fournit une string, on a la met dans un tableau
                return [$tagsAsString];
            }
        ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
