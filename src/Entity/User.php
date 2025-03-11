<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\Column(length: 20)]
    private ?string $NPI = null;

    #[ORM\Column(length: 100)]
    private ?string $Name = null;

    #[ORM\Column(length: 200)]
    private ?string $Firstname = null;

    #[ORM\Column(length: 200)]
    private ?string $Username = null;

    #[ORM\Column(length: 200)]
    private ?string $Email = null;

    #[ORM\Column(length: 200)]
    private ?string $Telephone = null;

    #[ORM\Column(length: 200)]
    private ?string $Password = null;

    #[ORM\Column(length: 200)]
    private ?string $Role = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Niveau = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Matiere = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Situationmatrimoniale = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $Date_inscription = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $Date_validation = null;

    public function getNPI(): ?string
    {
        return $this->NPI;
    }

    public function setNPI(string $NPI): static
    {
        $this->NPI = $NPI;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): static
    {
        $this->Name = $Name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->Firstname;
    }

    public function setFirstname(string $Firstname): static
    {
        $this->Firstname = $Firstname;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->Username;
    }

    public function setUsername(string $Username): static
    {
        $this->Username = $Username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): static
    {
        $this->Email = $Email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->Telephone;
    }

    public function setTelephone(string $Telephone): static
    {
        $this->Telephone = $Telephone;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): static
    {
        $this->Password = $Password;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->Role;
    }

    public function setRole(string $Role): static
    {
        $this->Role = $Role;

        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->Niveau;
    }

    public function setNiveau(?string $Niveau): static
    {
        $this->Niveau = $Niveau;

        return $this;
    }

    public function getMatiere(): ?string
    {
        return $this->Matiere;
    }

    public function setMatiere(?string $Matiere): static
    {
        $this->Matiere = $Matiere;

        return $this;
    }

    public function getSituationmatrimoniale(): ?string
    {
        return $this->Situationmatrimoniale;
    }

    public function setSituationmatrimoniale(?string $Situationmatrimoniale): static
    {
        $this->Situationmatrimoniale = $Situationmatrimoniale;

        return $this;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->Date_inscription;
    }

    public function setDateInscription(?\DateTimeInterface $Date_inscription): static
    {
        $this->Date_inscription = $Date_inscription;

        return $this;
    }

    public function getDateValidation(): ?\DateTimeInterface
    {
        return $this->Date_validation;
    }

    public function setDateValidation(?\DateTimeInterface $Date_validation): static
    {
        $this->Date_validation = $Date_validation;

        return $this;
    }

    //Validité du password ?
    public function isValidPasswordUser(string $Password): bool
    {
        return $this->Password === $Password;
    }

    //Validité du Role ?
    public function isValidRole(string $Role): bool
    {
        return $this->Role === $Role;
    }
}
