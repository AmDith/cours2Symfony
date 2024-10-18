<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('telephone', TextType::class, [
            'required' => false,//pour désactiver la validation du html 5
            'attr' => [
                'placeholder' => 'Téléphone ',
                // 'pattern' => '^([77|78|76])[0-9]{7}$',
                // 'class' => 'text-red-500'
            ],
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez saisir un numéro de téléphone',
                ]),
                new NotNull([
                    'message' => 'Le champ est obligatoire',
                ]),
                new Regex(
                    '/^(77|78|76)([0-9]{7})$/',
                    'Le numéro de téléphone doit être au format 77xxxxxxx ou 78xxxx ou 76xxxx'
                    )
            ]
        ])
        ->add('Search', SubmitType::class, [
            'attr' => [
                'class' => 'ml-2 mb-4 px-4 py-2 border border-green-800 hover:bg-green-800 hover:text-white font-semibold rounded-md'
            ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
