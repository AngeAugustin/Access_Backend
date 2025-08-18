<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotificationRepository::class)]
class Notification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $Id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Message = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Date_creation = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $Initiator = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $Destinator = null;

    public function getId(): ?int
    {
        return $this->Id;
    }

    public function getType(): ?string
    {
        return $this->Type;
    }

    public function setType(?string $Type): static
    {
        $this->Type = $Type;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->Message;
    }

    public function setMessage(?string $Message): static
    {
        $this->Message = $Message;

        return $this;
    }

    public function getDateCreation(): ?string
    {
        return $this->Date_creation;
    }

    public function setDateCreation(?string $Date_creation): static
    {
        $this->Date_creation = $Date_creation;

        return $this;
    }

    public function getInitiator(): ?string
    {
        return $this->Initiator;
    }

    public function setInitiator(?string $Initiator): static
    {
        $this->Initiator = $Initiator;

        return $this;
    }

    public function getDestinator(): ?string
    {
        return $this->Destinator;
    }

    public function setDestinator(?string $Destinator): static
    {
        $this->Destinator = $Destinator;

        return $this;
    }
}
