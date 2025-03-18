<?php

namespace App\Entity;

use App\Repository\EducateurRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EducateurRepository::class)]
class Educateur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $Id = null;

    #[ORM\Column(length: 20)]
    private ?string $NPI = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Date_naissance = null;

    #[ORM\Column(length: 200)]
    private ?string $Situation_matrimoniale = null;

    #[ORM\Column(length: 200)]
    private ?string $Garant_1 = null;

    #[ORM\Column(length: 200)]
    private ?string $Adresse_garant1 = null;

    #[ORM\Column(length: 200)]
    private ?string $Garant_2 = null;

    #[ORM\Column(length: 200)]
    private ?string $Adresse_garant2 = null;

    #[ORM\Column(length: 200)]
    private ?string $Carte_identite = null;

    #[ORM\Column(length: 200)]
    private ?string $Casier_judiciaire = null;

    public function getId(): ?int
    {
        return $this->Id;
    }

    public function getNPI(): ?string
    {
        return $this->NPI;
    }

    public function setNPI(string $NPI): static
    {
        $this->NPI = $NPI;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->Date_naissance;
    }

    public function setDateNaissance(\DateTimeInterface $Date_naissance): static
    {
        $this->Date_naissance = $Date_naissance;

        return $this;
    }

    public function getSituationMatrimoniale(): ?string
    {
        return $this->Situation_matrimoniale;
    }

    public function setSituationMatrimoniale(string $Situation_matrimoniale): static
    {
        $this->Situation_matrimoniale = $Situation_matrimoniale;

        return $this;
    }

    public function getGarant1(): ?string
    {
        return $this->Garant_1;
    }

    public function setGarant1(string $Garant_1): static
    {
        $this->Garant_1 = $Garant_1;

        return $this;
    }

    public function getAdresseGarant1(): ?string
    {
        return $this->Adresse_garant1;
    }

    public function setAdresseGarant1(string $Adresse_garant1): static
    {
        $this->Adresse_garant1 = $Adresse_garant1;

        return $this;
    }

    public function getGarant2(): ?string
    {
        return $this->Garant_2;
    }

    public function setGarant2(string $Garant_2): static
    {
        $this->Garant_2 = $Garant_2;

        return $this;
    }

    public function getAdresseGarant2(): ?string
    {
        return $this->Adresse_garant2;
    }

    public function setAdresseGarant2(string $Adresse_garant2): static
    {
        $this->Adresse_garant2 = $Adresse_garant2;

        return $this;
    }

    public function getCarteIdentite(): ?string
    {
        return $this->Carte_identite;
    }

    public function setCarteIdentite(string $Carte_identite): static
    {
        $this->Carte_identite = $Carte_identite;

        return $this;
    }

    public function getCasierJudiciaire(): ?string
    {
        return $this->Casier_judiciaire;
    }

    public function setCasierJudiciaire(string $Casier_judiciaire): static
    {
        $this->Casier_judiciaire = $Casier_judiciaire;

        return $this;
    }
}
