<?php

namespace App\DTO\Entity;


class ClientSearch
{
    

  
    private string $telephone;

    
    private string $Surname;

    

    public function __construct()
    {
    }

    public function getTelephone(): string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getSurname(): string
    {
        return $this->Surname;
    }

    public function setSurname(string $Surname): static
    {
        $this->Surname = $Surname;

        return $this;
    }

}
