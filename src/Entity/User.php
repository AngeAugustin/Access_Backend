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

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Adresse = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Statut_profil = null;

    #[ORM\Column(length: 240, nullable: true)]
    private ?string $Photo = null;

    #[ORM\Column(nullable: true)]
    private ?int $Nombre_enfants = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Code_secret = null;

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

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(?string $Adresse): static
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    public function getStatutProfil(): ?string
    {
        return $this->Statut_profil;
    }

    public function setStatutProfil(?string $Statut_profil): static
    {
        $this->Statut_profil = $Statut_profil;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->Photo;
    }

    public function setPhoto(?string $Photo): static
    {
        $this->Photo = $Photo;

        return $this;
    }

    public function getNombreEnfants(): ?int
    {
        return $this->Nombre_enfants;
    }

    public function setNombreEnfants(?int $Nombre_enfants): static
    {
        $this->Nombre_enfants = $Nombre_enfants;

        return $this;
    }

    public function getCodeSecret(): ?string
    {
        return $this->Code_secret;
    }

    public function setCodeSecret(?string $Code_secret): static
    {
        $this->Code_secret = $Code_secret;

        return $this;
    }

   
}
