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

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $Date_naissance = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Situation_matrimoniale = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Garant_1 = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Adresse_garant1 = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Garant_2 = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Adresse_garant2 = null;

    #[ORM\Column(type: 'blob', nullable: true)]
    private $Carte_identite = null;

    #[ORM\Column(type: 'blob', nullable: true)]
    private $Casier_judiciaire = null;

    #[ORM\Column(nullable: true)]
    private ?int $Experience = null;

    #[ORM\Column(length: 240, nullable: true)]
    private ?string $Parcours = null;

    #[ORM\Column(nullable: true)]
    private ?int $Etoiles = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Dispo1 = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Dispo2 = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Dispo3 = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Dispo4 = null;

    // Jours des disponibilités (Lundi, Mardi, Mercredi, etc.)
    #[ORM\Column(length: 20, nullable: true)]
    private ?string $Dispo1_jour = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $Dispo2_jour = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $Dispo3_jour = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $Dispo4_jour = null;

    // Heures des disponibilités (intervalles de 3h : 8h-11h, 11h-14h, 14h-17h, 17h-20h)
    #[ORM\Column(length: 20, nullable: true)]
    private ?string $Dispo1_heure = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $Dispo2_heure = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $Dispo3_heure = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $Dispo4_heure = null;

    #[ORM\Column(type: 'blob', nullable: true)]
    private $Photo_educateur = null;

    #[ORM\Column(type: 'blob', nullable: true)]
    private $Diplome_academique = null;

    #[ORM\Column(type: 'blob', nullable: true)]
    private $Diplome_professionnel = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Niveau = null;

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

    public function getCarteIdentite()
    {
        return $this->Carte_identite;
    }

    public function setCarteIdentite($Carte_identite): void
    {
        $this->Carte_identite = $Carte_identite;
    }

    public function getCasierJudiciaire()
    {
        return $this->Casier_judiciaire;
    }

    public function setCasierJudiciaire($Casier_judiciaire): void
    {
        $this->Casier_judiciaire = $Casier_judiciaire;
    }

    public function getExperience(): ?string
    {
        return $this->Experience;
    }

    public function setExperience(?string $Experience): static
    {
        $this->Experience = $Experience;

        return $this;
    }

    public function getParcours(): ?string
    {
        return $this->Parcours;
    }

    public function setParcours(?string $Parcours): static
    {
        $this->Parcours = $Parcours;

        return $this;
    }

    public function getEtoiles(): ?int
    {
        return $this->Etoiles;
    }

    public function setEtoiles(?int $Etoiles): static
    {
        $this->Etoiles = $Etoiles;

        return $this;
    }

    public function getDispo1(): ?string
    {
        return $this->Dispo1;
    }

    public function setDispo1(?string $Dispo1): static
    {
        $this->Dispo1 = $Dispo1;

        return $this;
    }

    public function getDispo2(): ?string
    {
        return $this->Dispo2;
    }

    public function setDispo2(?string $Dispo2): static
    {
        $this->Dispo2 = $Dispo2;

        return $this;
    }

    public function getDispo3(): ?string
    {
        return $this->Dispo3;
    }

    public function setDispo3(?string $Dispo3): static
    {
        $this->Dispo3 = $Dispo3;

        return $this;
    }

    public function getDispo4(): ?string
    {
        return $this->Dispo4;
    }

    public function setDispo4(?string $Dispo4): static
    {
        $this->Dispo4 = $Dispo4;

        return $this;
    }

    // Getters et setters pour les jours des disponibilités
    public function getDispo1Jour(): ?string
    {
        return $this->Dispo1_jour;
    }

    public function setDispo1Jour(?string $Dispo1_jour): static
    {
        $this->Dispo1_jour = $Dispo1_jour;

        return $this;
    }

    public function getDispo2Jour(): ?string
    {
        return $this->Dispo2_jour;
    }

    public function setDispo2Jour(?string $Dispo2_jour): static
    {
        $this->Dispo2_jour = $Dispo2_jour;

        return $this;
    }

    public function getDispo3Jour(): ?string
    {
        return $this->Dispo3_jour;
    }

    public function setDispo3Jour(?string $Dispo3_jour): static
    {
        $this->Dispo3_jour = $Dispo3_jour;

        return $this;
    }

    public function getDispo4Jour(): ?string
    {
        return $this->Dispo4_jour;
    }

    public function setDispo4Jour(?string $Dispo4_jour): static
    {
        $this->Dispo4_jour = $Dispo4_jour;

        return $this;
    }

    // Getters et setters pour les heures des disponibilités
    public function getDispo1Heure(): ?string
    {
        return $this->Dispo1_heure;
    }

    public function setDispo1Heure(?string $Dispo1_heure): static
    {
        $this->Dispo1_heure = $Dispo1_heure;

        return $this;
    }

    public function getDispo2Heure(): ?string
    {
        return $this->Dispo2_heure;
    }

    public function setDispo2Heure(?string $Dispo2_heure): static
    {
        $this->Dispo2_heure = $Dispo2_heure;

        return $this;
    }

    public function getDispo3Heure(): ?string
    {
        return $this->Dispo3_heure;
    }

    public function setDispo3Heure(?string $Dispo3_heure): static
    {
        $this->Dispo3_heure = $Dispo3_heure;

        return $this;
    }

    public function getDispo4Heure(): ?string
    {
        return $this->Dispo4_heure;
    }

    public function setDispo4Heure(?string $Dispo4_heure): static
    {
        $this->Dispo4_heure = $Dispo4_heure;

        return $this;
    }

    public function getPhotoEducateur()
    {
        return $this->Photo_educateur;
    }

    public function setPhotoEducateur($Photo_educateur): void
    {
        $this->Photo_educateur = $Photo_educateur;
    }

    public function getDiplomeAcademique()
    {
        return $this->Diplome_academique;
    }

    public function setDiplomeAcademique($Diplome_academique): void
    {
        $this->Diplome_academique = $Diplome_academique;
    }

    public function getDiplomeProfessionnel()
    {
        return $this->Diplome_professionnel;
    }

    public function setDiplomeProfessionnel($Diplome_professionnel): void
    {
        $this->Diplome_professionnel = $Diplome_professionnel;
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
}
