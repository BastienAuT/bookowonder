<?php

namespace App\Form;

use App\Entity\Recommendation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecommendationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('content', null, [
                "label" => "Avis de l'utilisateur"
            ])
            ->add('recommendation', null, [
                "label" => "Est recommandé par l'utilisateur",
                'constraints' => [
                    new NotBlank(),
                ]
            ])
            ->add('book', null, [
                "label" => "Nom du livre"
            ])
            ->add('user', null, [
                "label" => "Nom d'affichage de l'utilisateur"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recommendation::class,
        ]);
    }
}
