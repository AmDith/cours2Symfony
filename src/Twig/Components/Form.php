<?php

namespace App\Twig\Components;

use App\Form\InfoClientType;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[AsLiveComponent]
final class Form extends AbstractController
{
    // use ComponentWithFormTrait;
    use DefaultActionTrait;

    #[LiveProp(useSerializerForHydration: true)]
    public string $clients = '';

    public function getClientList(): string
    {
        return $this->clients;
    }

    // protected function instantiateForm(): FormInterface
    // {
    //     return $this->createForm(InfoClientType::class);
    // }
}
