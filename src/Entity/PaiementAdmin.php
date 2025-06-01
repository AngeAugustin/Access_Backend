<?php

namespace App\Entity;

use App\Repository\PaiementAdminRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaiementAdminRepository::class)]
class PaiementAdmin
{
    #[ORM\Id]
    #[ORM\Column(length: 20)]
    private ?string $Id_paiement = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Montant_paiement = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Date_paiement = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Statut_paiement = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $NPI_agent = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Nom_agent = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Prenom_agent = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Role_agent = null;

    public function getIdPaiement(): ?string
    {
        return $this->Id_paiement;
    }
    public function setIdPaiement(string $Id_paiement): static
    {
        $this->Id_paiement = $Id_paiement;
        return $this;
    }

    public function getMontantPaiement(): ?string
    {
        return $this->Montant_paiement;
    }

    public function setMontantPaiement(?string $Montant_paiement): static
    {
        $this->Montant_paiement = $Montant_paiement;

        return $this;
    }

    public function getDatePaiement(): ?string
    {
        return $this->Date_paiement;
    }

    public function setDatePaiement(?string $Date_paiement): static
    {
        $this->Date_paiement = $Date_paiement;

        return $this;
    }

    public function getStatutPaiement(): ?string
    {
        return $this->Statut_paiement;
    }

    public function setStatutPaiement(?string $Statut_paiement): static
    {
        $this->Statut_paiement = $Statut_paiement;

        return $this;
    }

    public function getNPIAgent(): ?string
    {
        return $this->NPI_agent;
    }

    public function setNPIAgent(?string $NPI_agent): static
    {
        $this->NPI_agent = $NPI_agent;

        return $this;
    }

    public function getNomAgent(): ?string
    {
        return $this->Nom_agent;
    }

    public function setNomAgent(?string $Nom_agent): static
    {
        $this->Nom_agent = $Nom_agent;

        return $this;
    }

    public function getPrenomAgent(): ?string
    {
        return $this->Prenom_agent;
    }

    public function setPrenomAgent(?string $Prenom_agent): static
    {
        $this->Prenom_agent = $Prenom_agent;

        return $this;
    }

    public function getRoleAgent(): ?string
    {
        return $this->Role_agent;
    }

    public function setRoleAgent(?string $Role_agent): static
    {
        $this->Role_agent = $Role_agent;

        return $this;
    }
}
