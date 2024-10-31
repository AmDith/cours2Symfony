<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\Serializer\Annotation\Groups;

use Symfony\Component\Serializer\Annotation\MaxDepth;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
//Validation du formulaire pour l'unicité
#[UniqueEntity('telephone', message:'Le téléphone doit  être unique')]
#[UniqueEntity('Surname', message:'Le surmane doit  être unique')]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 13,  unique: true)]
    #[Groups(['clients'])]
    private ?string $telephone = null;

    #[ORM\Column(length: 50,  unique: true)]
    #[Groups(['clients'])]
    //validation sur un entité si le formType est relier à l'entité
    #[Assert\NotBlank(
        message: 'Le surname du client est obligatoire',
    )]
    private ?string $Surname = null;

    #[ORM\Column(length: 100)]
    #[Groups(['clients'])]
    private ?string $adresse = null;

    #[ORM\Column]
    #[Groups(['clients'])]
    private ?\DateTimeImmutable $createAt = null;

    #[ORM\Column]
    #[Groups(['clients'])]
    private ?\DateTimeImmutable $updateAt = null;

   

    /**
     * @var Collection<int, Dette>
     */
    #[ORM\OneToMany(targetEntity: Dette::class, mappedBy: 'client', orphanRemoval: true, cascade:['persist'])]
    #[MaxDepth(1)]
    private Collection $dettes;

    #[ORM\OneToOne(mappedBy: 'cient', cascade: ['persist', 'remove'])]
    private ?User $userId = null;

    public function __construct()
    {
        $this->createAt = new \DateTimeImmutable();
        $this->updateAt = new \DateTimeImmutable();
        $this->dettes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->Surname;
    }

    public function setSurname(string $Surname): static
    {
        $this->Surname = $Surname;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeImmutable
    {
        return $this->createAt;
    }

    public function setCreateAt(\DateTimeImmutable $createAt): static
    {
        $this->createAt = $createAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeImmutable
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeImmutable $updateAt): static
    {
        $this->updateAt = $updateAt;

        return $this;
    }

  

    /**
     * @return Collection<int, Dette>
     */
    public function getDettes(): Collection
    {
        return $this->dettes;
    }

    public function addDette(Dette $dette): static
    {
        if (!$this->dettes->contains($dette)) {
            $this->dettes->add($dette);
            $dette->setClient($this);
        }

        return $this;
    }

    public function removeDette(Dette $dette): static
    {
        if ($this->dettes->removeElement($dette)) {
            // set the owning side to null (unless already changed)
            if ($dette->getClient() === $this) {
                $dette->setClient(null);
            }
        }

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->userId;
    }

    public function setUserId(?User $userId): static
    {
        // unset the owning side of the relation if necessary
        if ($userId === null && $this->userId !== null) {
            $this->userId->setCient(null);
        }

        // set the owning side of the relation if necessary
        if ($userId !== null && $userId->getCient() !== $this) {
            $userId->setCient($this);
        }

        $this->userId = $userId;

        return $this;
    }
}
