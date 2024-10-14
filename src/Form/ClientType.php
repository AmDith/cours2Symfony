<?php

// src/Form/ClientType.php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('telephone', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le champ téléphone ne peut pas être vide.']),
                ],
            ])
            ->add('Surname', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le champ surname ne peut pas être vide.']),
                ],
            ])
            ->add('adresse', TextareaType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Le champ adresse ne peut pas être vide.']),
                ],
            ])
            ->add('Save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}

