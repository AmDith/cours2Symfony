<?php

namespace App\EventSubscriber;

use App\DTO\ClientDto;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ClientExceptionSubscriber implements EventSubscriberInterface
{
    private $session;
    private $clientDto;

    public function __construct(SessionInterface $session, ClientDto $clientDto)
    {
        $this->session = $session;
        $this->clientDto = $clientDto;
    }


    public function onFormPostSubmit(PostSubmitEvent $event): void
    {
        $form = $event->getForm();
        $data = $form->getData();

        if (!$form->isSubmitted() || !$form->isValid()) {
            return;
        }
        if ($data['isActive']) {
            $telephone = $data['telephone'] ?? null;

            if ($telephone) {
                // Stocker le téléphone dans le DTO et la session
                $this->clientDto->setTelephone($telephone);
                $this->session->set('telephone', $this->clientDto->getTelephone());
            }
        }

        
    }


    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::POST_SUBMIT => 'onFormPostSubmit',
        ];
    }
}
