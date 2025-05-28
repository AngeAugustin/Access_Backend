<?php

namespace App\Entity;

use App\Repository\SeanceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeanceRepository::class)]
class Seance
{
    #[ORM\Id]
    #[ORM\Column(length: 20)]
    private ?string $Id_seance = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $Reference_tutorat = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $Date_seance = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Heure_seance = null; 

    #[ORM\Column(length: 240, nullable: true)]
    private ?string $Observation = null;

    #[ORM\Column(length: 250, nullable: true)]
    private ?string $Travail_effectue = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $NPI_educateur = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $NPI_enfant = null;

    public function getIdSeance(): ?string
    {
        return $this->Id_seance;
    }

    public function setIdSeance(string $Id_seance): static
    {
        $this->Id_seance = $Id_seance;

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

    public function getDateSeance(): ?\DateTimeInterface
    {
        return $this->Date_seance;
    }

    public function setDateSeance(?\DateTimeInterface $Date_seance): static
    {
        $this->Date_seance = $Date_seance;

        return $this;
    }

    public function getHeureSeance(): ?string
    {
        return $this->Heure_seance;
    }

    public function setHeureSeance(?string $Heure_seance): static
    {
        $this->Heure_seance = $Heure_seance;

        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->Observation;
    }

    public function setObservation(?string $Observation): static
    {
        $this->Observation = $Observation;

        return $this;
    }

    public function getTravailEffectue(): ?string
    {
        return $this->Travail_effectue;
    }

    public function setTravailEffectue(?string $Travail_effectue): static
    {
        $this->Travail_effectue = $Travail_effectue;

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
}
