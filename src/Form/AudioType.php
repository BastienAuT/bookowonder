<?php

namespace App\Form;

use App\Entity\Audio;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;

class AudioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Titre de la musique'
            ])
            ->add('music', UrlType::class, [
                'label' => 'Url de la musique'
            ])
            ->add('image', FileType::class, [
                'label' => 'Image de la musique',
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
            // ->add('createdAt')
            // ->add('updatedAt')
            ->add('categories', null, [
                'label' => "Catégories (Si vous ne trouvez pas une catégorie, veuillez l'ajouter au préalable dans l'interface d'administration Catégorie) ",
                'expanded' => true,
                'multiple' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Audio::class,
        ]);
    }
}
