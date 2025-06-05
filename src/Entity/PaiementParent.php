<?php

namespace App\Entity;

use App\Repository\PaiementParentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaiementParentRepository::class)]
class PaiementParent
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
    private ?string $NPI_payeur = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Nom_payeur = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Prenom_payeur = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Role_payeur = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Id_transaction = null;

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

    public function getNPIPayeur(): ?string
    {
        return $this->NPI_payeur;
    }

    public function setNPIPayeur(?string $NPI_payeur): static
    {
        $this->NPI_payeur = $NPI_payeur;

        return $this;
    }

    public function getNomPayeur(): ?string
    {
        return $this->Nom_payeur;
    }

    public function setNomPayeur(?string $Nom_payeur): static
    {
        $this->Nom_payeur = $Nom_payeur;

        return $this;
    }

    public function getPrenomPayeur(): ?string
    {
        return $this->Prenom_payeur;
    }

    public function setPrenomPayeur(?string $Prenom_payeur): static
    {
        $this->Prenom_payeur = $Prenom_payeur;

        return $this;
    }

    public function getRolePayeur(): ?string
    {
        return $this->Role_payeur;
    }

    public function setRolePayeur(?string $Role_payeur): static
    {
        $this->Role_payeur = $Role_payeur;

        return $this;
    }

    public function getIdTransaction(): ?string
    {
        return $this->Id_transaction;
    }

    public function setIdTransaction(?string $Id_transaction): static
    {
        $this->Id_transaction = $Id_transaction;

        return $this;
    }
}
