<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\Column]
    private ?int $Id_reclamation = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $NPI_demandant = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $NPI_traitant = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Motif = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Details = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $Statut = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Mail_demandant = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Nom_demandant = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Prenom_demandant = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Role_demandant = null;

    public function getIdReclamation(): ?int
    {
        return $this->Id_reclamation;
    }
    public function setIdReclamation(int $Id_reclamation): static
    {
        $this->Id_reclamation = $Id_reclamation;
        return $this;
    }

    public function getNPIDemandant(): ?string
    {
        return $this->NPI_demandant;
    }

    public function setNPIDemandant(?string $NPI_demandant): static
    {
        $this->NPI_demandant = $NPI_demandant;

        return $this;
    }

    public function getNPITraitant(): ?string
    {
        return $this->NPI_traitant;
    }

    public function setNPITraitant(?string $NPI_traitant): static
    {
        $this->NPI_traitant = $NPI_traitant;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->Motif;
    }

    public function setMotif(?string $Motif): static
    {
        $this->Motif = $Motif;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->Details;
    }

    public function setDetails(?string $Details): static
    {
        $this->Details = $Details;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->Statut;
    }

    public function setStatut(?string $Statut): static
    {
        $this->Statut = $Statut;

        return $this;
    }

    public function getMailDemandant(): ?string
    {
        return $this->Mail_demandant;
    }

    public function setMailDemandant(?string $Mail_demandant): static
    {
        $this->Mail_demandant = $Mail_demandant;

        return $this;
    }

    public function getNomDemandant(): ?string
    {
        return $this->Nom_demandant;
    }

    public function setNomDemandant(?string $Nom_demandant): static
    {
        $this->Nom_demandant = $Nom_demandant;

        return $this;
    }

    public function getPrenomDemandant(): ?string
    {
        return $this->Prenom_demandant;
    }

    public function setPrenomDemandant(?string $Prenom_demandant): static
    {
        $this->Prenom_demandant = $Prenom_demandant;

        return $this;
    }

    public function getRoleDemandant(): ?string
    {
        return $this->Role_demandant;
    }

    public function setRoleDemandant(?string $Role_demandant): static
    {
        $this->Role_demandant = $Role_demandant;

        return $this;
    }
}
