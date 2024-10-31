<?php

// src/Form/ClientType.php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use App\EventSubscriber\FormClientSubscriber;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ClientType extends AbstractType
{
    private FormClientSubscriber $subscriber;

    public function __construct(FormClientSubscriber $subscriber)
    {
        $this->subscriber = $subscriber;
    }
    // public function buildForm(FormBuilderInterface $builder, array $options): void
    // {
    //     $builder
    //         ->add('telephone', TextType::class, [
    //             'required' => false,//pour désactiver la validation du html 5
    //             'attr' => [
    //                 'placeholder' => 'Numéro de téléphone ',
    //                 // 'pattern' => '^([77|78|76])[0-9]{7}$',
    //                 // 'class' => 'text-red-500'
    //             ],
    //             'constraints' => [
    //                 new NotBlank([
    //                     'message' => 'Veuillez saisir un numéro de téléphone',
    //                 ]),
    //                 new NotNull([
    //                     'message' => 'Le champ est obligatoire',
    //                 ]),
    //                 new Regex(
    //                     '/^(77|78|76)([0-9]{7})$/',
    //                     'Le numéro de téléphone doit être au format 77xxxxxxx ou 78xxxx ou 76xxxx'
    //                     )
    //             ]
    //         ])
    //         ->add('Surname', TextType::class, [
    //             'required' => false,
    //             'attr' => [
    //                 'placeholder' => 'Surname',
    //             ],
    //             'constraints' => [
    //                 new NotBlank([
    //                     'message' => 'Veuillez saisir un surname',
    //                 ])
    //             ]])
    //         ->add('adresse', TextareaType::class, [
    //             'required' => false,
    //             'attr' => [
    //                 'placeholder' => 'Adresse ',
    //             ],])

    //         ->add('addUser', CheckboxType::class, [
    //             'label' => 'Ajouter un compte',
    //             'required' => false,
    //             'data' => false,
    //             'mapped' => false,
    //             'attr' => [
    //                 'class' => 'form-check-input'
    //             ]
    //         ])

    //         ->add('userId', UserType::class, [
    //             'label' => false,
    //             'attr' => [
    //                 // 'style' => 'display:none;',
    //             ]
    //         ])
            
                
    //         ->add('Save', SubmitType::class, [
    //             'attr' => [
    //                 'class' => 'ml-2 mb-4 px-4 py-2 border border-green-800 hover:bg-green-800 hover:text-white font-semibold rounded-md'
    //             ]
    //         ]);
    // }

    // public function configureOptions(OptionsResolver $resolver): void
    // {
    //     $resolver->setDefaults([
    //         'data_class' => Client::class,
    //     ]);
    // }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('telephone', TextType::class, [
                'required' => false,
                'attr' => [
                    'placeholder' => '773461882',
                    // 'pattern' => '^([77|78|76])[0-9]{7}$',
                    // 'class' => 'text-danger',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner un numéro de téléphone valide.',
                    ]),
                    new NotNull([
                        'message' => 'Le téléphone ne peut pas être vide',
                    ]),
                    new Regex(
                        '/^(77|78|76)([0-9]{7})$/',
                        'Le numéro de téléphone doit être au format 77XXXXXX ou 78XXXXXX ou 76XXXXXX'
                    )

                ]

            ])
            ->add('surname', TextType::class, [
                'required' => false,
            ])
            
            ->add('adresse', TextareaType::class, [
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner une adresse valide.',
                    ]),
                ]
            ])

            ->add('addUser', CheckboxType::class, [
                'label' => 'Ajouter un compte ?',
                'required' => false,
                'data' => false,
                'mapped' => false,

                'attr' => [
                    'class' => 'form-check-input',
                ],
            ])

            // ->add('Save', SubmitType::class)

            // ->addEventListener(FormEvents::PRE_SUBMIT, function (PreSubmitEvent $event): void {
            //     $formData = $event->getData(); // Récupère les données du formulaire
            //     $form = $event->getForm();
            //     // dd($form);
            //     if (isset($formData['addUser']) && $formData['addUser'] == "1") {

            //         $form
            //             ->add('user', UserType::class, [
            //                 'label' => false,
            //                 'attr' => [],
            //             ]);
            //     }
            // })
            ->add('profileImage', FileType::class, [
                'label' => 'Upload Profile Image',
                'required' => false,
                'mapped' => false, // Ne lie pas ce champ à l'entité Client directement
                'attr' => ['accept' => 'image/*'],
            ])

            ->addEventSubscriber($this->subscriber);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
            'validation_groups' => ['Default'],
        ]);
    }

}

