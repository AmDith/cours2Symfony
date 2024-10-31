<?php

namespace App\EventSubscriber;

use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ClientExceptionSubscriber implements EventSubscriberInterface
{
    private SessionInterface $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }
   
   
    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::POST_SUBMIT => 'onFormPostSubmit',
        ];
    }


    public function onFormPostSubmit(FormEvent $event): void
    {
        $form = $event->getForm();
        $data = $event->getData();

        $telephone = $data['telephone'] ?? null;

           if (!$telephone) {
            $form->addError(new FormError('Le numéro de téléphone est requis.'));
         }
        

        
    }


    
}
