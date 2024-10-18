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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class InfoClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('telephone', TextType::class, [
                'required' => false, // pour désactiver la validation du html 5
                'attr' => [
                    'placeholder' => 'Numéro de téléphone ',
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
            ->add('Surname', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => 'Surname',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir un surname',
                    ])
                ]
            ])
            ->add('isActive', CheckboxType::class, [ // Ajout du champ Checkbox
                'required' => false, // non requis par défaut
                'label' => 'Actif', // Label du checkbox
            ])
            ->add('Save', SubmitType::class, [
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
