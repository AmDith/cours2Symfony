<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('login')
            ->add('password')
            // ->add('createAt', null, [
            //     'widget' => 'single_text',
            // ])
            // ->add('updateAt', null, [
            //     'widget' => 'single_text',
            // ])
            ->add('isBlocked')
            // ->add('client', EntityType::class, [
            //     'class' => Client::class,
            //     'choice_label' => 'id',
            // ])
            ->add('Save', SubmitType::class, [
                'attr' => [
                    'class' => 'ml-2 mb-4 px-4 py-2 border border-green-800 hover:bg-green-800 hover:text-white font-semibold rounded-md'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
