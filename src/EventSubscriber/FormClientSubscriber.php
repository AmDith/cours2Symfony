<?php

namespace App\EventSubscriber;

use App\Form\UserType;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Form\Event\PreSubmitEvent;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\Event\PreSetDataEvent;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FormClientSubscriber implements EventSubscriberInterface
{
    private MailerInterface $mailer;
    private string $uploadDir;

    public function __construct(MailerInterface $mailer,string $uploadDir)
    {
        $this->mailer = $mailer;
        $this->uploadDir = $uploadDir;
    }
    
    public function onFormPreSubmit(PreSubmitEvent $event): void
    {
        $formData = $event->getData(); // Récupère les données du formulaire
        $form = $event->getForm();
        if (isset($formData['addUser']) && $formData['addUser'] == "1") {
            $form
                ->add('userId', UserType::class, [
                    'label' => false,
                    'attr' => [],
                ]);
        }
    }

    public function onUploadPreSubmit(PreSubmitEvent $event): void
    {
        $form = $event->getForm();
        $client = $event->getData();

        /** @var UploadedFile|null $uploadedFile */
        $uploadedFile = $form->get('profileImage')->getData();

        if ($uploadedFile) {
            $filename = uniqid() . '.' . $uploadedFile->guessExtension();

            try {
                $uploadedFile->move($this->uploadDir, $filename);
                $client->setProfileImage($filename); 
            } catch (FileException $e) {
                throw new \Exception("Le fichier n'a pas pu être téléchargé.");
            }
        }
    }

    public function onFormPostSubmit(PostSubmitEvent $event): void
    {
        $client = $event->getData();
        $form = $event->getForm();

        if ($form->get('addUser')->getData()) {
            $loginEmail = $client->getLogin();

            if ($loginEmail) {
                $this->sendClientEmail($loginEmail);
            }
        }
    }

    private function sendClientEmail(string $loginEmail): void
    {
        $email = (new Email())
            ->from('micheldith@gmail.com')
            ->to($loginEmail)
            ->subject('Bienvenue sur notre plateforme')
            ->text('Merci de vous être inscrit ! Votre compte a été créé avec succès.');

        $this->mailer->send($email);
    }


    public static function getSubscribedEvents(): array
    {
        return [
            'form.pre_submit' => 'onFormPreSubmit',
            'form.pre_submit' => 'onUploadPreSubmit',
            'form.pre_set_data' => 'onFormPreSetData',
            'form.post_submit' => 'onFormPostSubmit',
        ];
    }

    public function onFormPreSetData(PreSetDataEvent $event): void
    {
        
    }
}