<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                "label" => "Titre du livre",
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('synopsis', null, [
                "label" => "Résumé du livre"
            ])
            ->add('picture', FileType::class, [
                // "data_class" => null,
                "label" => "Image de couverture",
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
            ->add('epub', FileType::class, [
                // "data_class" => null,
                "mapped" => false,
                "label" => "Ficher Epub du livre",
                "required" => false,
                'constraints' => [
                    new File([
                        'mimeTypes' => [
                            'application/epub+zip',
                            
                        ],
                        'mimeTypesMessage' => 'Insérer un fichier au format epub',
                    ])
                ]
            ])
            ->add('isbn',null, [
                "label" => "Numéro ISBN du livre"
            ])
            ->add('publishedAt', null, [
                "label" => "Date de publication",
                'widget' => 'single_text',
            ])
            
            ->add('isHome', null, [
                "label" => "Affiché en première page ?"
            ])
            ->add('frontPic', FileType::class, [
                // "data_class" => null,
                "label" => "Image en frontpage",
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
            ->add('author', null, [
                "label" => "Auteur (Si vous ne trouvez pas l'auteur, veuillez l'ajouter au préalable dans l'interface d'administration Auteur)"
            ])
            ->add('editor', null, [
                "label" => "Editeur (Si vous ne trouvez pas l'éditeur, veuillez l'ajouter au préalable dans l'interface d'administration Editeur) "
            ])
            ->add('categories', null, [
                "label" => "Catégories (Si vous ne trouvez pas une catégorie, veuillez l'ajouter au préalable dans l'interface d'administration Catégorie) ",
                'expanded' => true,
                'multiple' => true,
            ])

            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                // like all programmation with events, $event has all infos on event
                // we can retrieve informations of the form and entity whit $event
                $book = $event->getData();
                $form = $event->getForm();

                // if $user exists ( edit mode ) =>  required : false
                // else ( add mode ) => required : true
                // it is not possible to modify and existing field :'(
                // but we can delete it and recreate it !

                //if user id is empty, we have to create a user

                if ($book->getId() == null){
                    $form->remove('picture');
                    $form->remove('frontPic');
                    $form->remove('epub');
                    

                    $form->add('picture', FileType::class, [
                        // "data_class" => null,
                        "label" => "Image de couverture",
                        'mapped' => false,
                        'required' => true,
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
                    ->add('frontPic', FileType::class, [
                        // "data_class" => null,
                        "label" => "Image en frontpage",
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
                    ->add('epub', FileType::class, [
                        // "data_class" => null ,
                        'mapped' => false,
                        "required" => true,
                        "label" => "Ficher Epub du livre",
                        'constraints' => [
                            new NotBlank(),
                            new File([
                                'mimeTypes' => [
                                    'application/epub+zip',
                                    
                                ],
                                'mimeTypesMessage' => 'Insérer un fichier au format epub',
                            ])
                        ]
                    ]);

                    }

            });

            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
