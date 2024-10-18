<?php

namespace App\Twig\Components;

use App\Repository\ClientRepository;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\LiveComponentInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;

#[AsLiveComponent('Dynamic')]
class Dynamic
{
    use DefaultActionTrait;
    public ?string $telephone = null;

    public function __construct(private ClientRepository $clientRepository) {}

    public function getClient(): ?array
    {
        if ($this->telephone) {
            $client = $this->clientRepository->findOneBy(['telephone' => $this->telephone]);

            if ($client) {
                return [
                    'name' => $client->getSurname(),
                    'telephone' => $client->getTelephone(),
                    // Ajoutez ici d'autres informations à afficher
                ];
            }
        }

        return null;
    }
}
