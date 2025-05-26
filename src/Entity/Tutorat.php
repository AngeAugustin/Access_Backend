<?php

namespace App\Entity;

use App\Repository\TutoratRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TutoratRepository::class)]
class Tutorat
{
    #[ORM\Id]
    #[ORM\Column(length: 20, nullable: true)]
    private ?string $Reference_tutorat = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $NPI_parent = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $NPI_educateur = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $NPI_enfant = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Duree_tutorat = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Seance1 = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Seance2 = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $Date_tutorat = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Statut_tutorat = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Observation_generale = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $Date_fin_tutorat = null;

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

    public function getNPIEnfant(): ?string
    {
        return $this->NPI_enfant;
    }

    public function setNPIEnfant(?string $NPI_enfant): static
    {
        $this->NPI_enfant = $NPI_enfant;

        return $this;
    }

    public function getDureeTutorat(): ?string
    {
        return $this->Duree_tutorat;
    }

    public function setDureeTutorat(?string $Duree_tutorat): static
    {
        $this->Duree_tutorat = $Duree_tutorat;

        return $this;
    }

    public function getSeance1(): ?string
    {
        return $this->Seance1;
    }

    public function setSeance1(?string $Seance1): static
    {
        $this->Seance1 = $Seance1;

        return $this;
    }

    public function getSeance2(): ?string
    {
        return $this->Seance2;
    }

    public function setSeance2(?string $Seance2): static
    {
        $this->Seance2 = $Seance2;

        return $this;
    }

    public function getDateTutorat(): ?\DateTimeInterface
    {
        return $this->Date_tutorat;
    }

    public function setDateTutorat(?\DateTimeInterface $Date_tutorat): static
    {
        $this->Date_tutorat = $Date_tutorat;

        return $this;
    }

    public function getStatutTutorat(): ?string
    {
        return $this->Statut_tutorat;
    }

    public function setStatutTutorat(?string $Statut_tutorat): static
    {
        $this->Statut_tutorat = $Statut_tutorat;

        return $this;
    }

    public function getObservationGenerale(): ?string
    {
        return $this->Observation_generale;
    }

    public function setObservationGenerale(?string $Observation_generale): static
    {
        $this->Observation_generale = $Observation_generale;

        return $this;
    }

    public function getDateFinTutorat(): ?\DateTimeInterface
    {
        return $this->Date_fin_tutorat;
    }

    public function setDateFinTutorat(?\DateTimeInterface $Date_fin_tutorat): static
    {
        $this->Date_fin_tutorat = $Date_fin_tutorat;

        return $this;
    }
}
