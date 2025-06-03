<?php

namespace App\Entity;

use App\Repository\PaiementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaiementRepository::class)]
class Paiement
{
    #[ORM\Id]
    #[ORM\Column(length: 20)]
    private ?string $Id_paiement = null; 

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $Reference_tutorat = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $NPI_parent = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $NPI_educateur = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $NPI_agent = null;

    #[ORM\Column(nullable: true)]
    private ?int $Duree_tutorat = null;

    #[ORM\Column(nullable: true)]
    private ?int $Nbre_paiements = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Classe_actuelle = null;

    #[ORM\Column(nullable: true)]
    private ?int $Montant_paiement1 = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Statut_paiement1 = null;

    #[ORM\Column(nullable: true)]
    private ?int $Montant_paiement2 = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Statut_paiement2 = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $Date_paiement1 = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $Date_paiement2 = null;

    #[ORM\Column(nullable: true)]
    private ?int $Montant_paiement3 = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Statut_paiement3 = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $Date_paiement3 = null;

    #[ORM\Column(nullable: true)]
    private ?int $Nbre_seances = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Paiement1 = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Paiement2 = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Paiement3 = null;

    public function getIdPaiement(): ?string
    {
        return $this->Id_paiement;
    }

    public function setIdPaiement(string $Id_paiement): static
    {
        $this->Id_paiement = $Id_paiement;
        return $this;
    }

    public function getReferenceTutorat(): ?string
    {
        return $this->Reference_tutorat;
    }

    public function setReferenceTutorat(?string $Reference_tutorat): static
    {
        $this->Reference_tutorat = $Reference_tutorat;

        return $this;
    }

    public function getNPIParent(): ?string
    {
        return $this->NPI_parent;
    }

    public function setNPIParent(?string $NPI_parent): static
    {
        $this->NPI_parent = $NPI_parent;

        return $this;
    }

    public function getNPIEducateur(): ?string
    {
        return $this->NPI_educateur;
    }

    public function setNPIEducateur(?string $NPI_educateur): static
    {
        $this->NPI_educateur = $NPI_educateur;

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

    public function getDureeTutorat(): ?int
    {
        return $this->Duree_tutorat;
    }

    public function setDureeTutorat(?int $Duree_tutorat): static
    {
        $this->Duree_tutorat = $Duree_tutorat;

        return $this;
    }

    public function getNbrePaiements(): ?int
    {
        return $this->Nbre_paiements;
    }

    public function setNbrePaiements(?int $Nbre_paiements): static
    {
        $this->Nbre_paiements = $Nbre_paiements;

        return $this;
    }

    public function getClasseActuelle(): ?string
    {
        return $this->Classe_actuelle;
    }

    public function setClasseActuelle(?string $Classe_actuelle): static
    {
        $this->Classe_actuelle = $Classe_actuelle;

        return $this;
    }

    public function getMontantPaiement1(): ?int
    {
        return $this->Montant_paiement1;
    }

    public function setMontantPaiement1(?int $Montant_paiement1): static
    {
        $this->Montant_paiement1 = $Montant_paiement1;

        return $this;
    }

    public function getStatutPaiement1(): ?string
    {
        return $this->Statut_paiement1;
    }

    public function setStatutPaiement1(?string $Statut_paiement1): static
    {
        $this->Statut_paiement1 = $Statut_paiement1;

        return $this;
    }

    public function getMontantPaiement2(): ?int
    {
        return $this->Montant_paiement2;
    }

    public function setMontantPaiement2(?int $Montant_paiement2): static
    {
        $this->Montant_paiement2 = $Montant_paiement2;

        return $this;
    }

    public function getStatutPaiement2(): ?string
    {
        return $this->Statut_paiement2;
    }

    public function setStatutPaiement2(?string $Statut_paiement2): static
    {
        $this->Statut_paiement2 = $Statut_paiement2;

        return $this;
    }

    public function getDatePaiement1(): ?\DateTimeInterface
    {
        return $this->Date_paiement1;
    }

    public function setDatePaiement1(?\DateTimeInterface $Date_paiement1): static
    {
        $this->Date_paiement1 = $Date_paiement1;

        return $this;
    }

    public function getDatePaiement2(): ?\DateTimeInterface
    {
        return $this->Date_paiement2;
    }

    public function setDatePaiement2(?\DateTimeInterface $Date_paiement2): static
    {
        $this->Date_paiement2 = $Date_paiement2;

        return $this;
    }

    public function getMontantPaiement3(): ?int
    {
        return $this->Montant_paiement3;
    }

    public function setMontantPaiement3(?int $Montant_paiement3): static
    {
        $this->Montant_paiement3 = $Montant_paiement3;

        return $this;
    }

    public function getStatutPaiement3(): ?string
    {
        return $this->Statut_paiement3;
    }

    public function setStatutPaiement3(?string $Statut_paiement3): static
    {
        $this->Statut_paiement3 = $Statut_paiement3;

        return $this;
    }

    public function getDatePaiement3(): ?\DateTimeInterface
    {
        return $this->Date_paiement3;
    }

    public function setDatePaiement3(?\DateTimeInterface $Date_paiement3): static
    {
        $this->Date_paiement3 = $Date_paiement3;

        return $this;
    }

    public function getNbreSeances(): ?int
    {
        return $this->Nbre_seances;
    }

    public function setNbreSeances(?int $Nbre_seances): static
    {
        $this->Nbre_seances = $Nbre_seances;

        return $this;
    }

    public function getPaiement1(): ?string
    {
        return $this->Paiement1;
    }

    public function setPaiement1(?string $Paiement1): static
    {
        $this->Paiement1 = $Paiement1;

        return $this;
    }

    public function getPaiement2(): ?string
    {
        return $this->Paiement2;
    }

    public function setPaiement2(?string $Paiement2): static
    {
        $this->Paiement2 = $Paiement2;

        return $this;
    }

    public function getPaiement3(): ?string
    {
        return $this->Paiement3;
    }

    public function setPaiement3(?string $Paiement3): static
    {
        $this->Paiement3 = $Paiement3;

        return $this;
    }
}
