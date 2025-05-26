<?php

namespace App\Entity;

use App\Repository\TarifRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TarifRepository::class)]
class Tarif
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Classe_actuelle = null;

    #[ORM\Column(nullable: true)]
    private ?int $Tarif_horaire = null;

    #[ORM\Column(nullable: true)]
    private ?int $Nbre_seances_semaine = null;

    #[ORM\Column(nullable: true)]
    private ?int $Nbre_heure_seance = null;

    #[ORM\Column]
    private ?int $Montant_seance = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTarifHoraire(): ?int
    {
        return $this->Tarif_horaire;
    }

    public function setTarifHoraire(?int $Tarif_horaire): static
    {
        $this->Tarif_horaire = $Tarif_horaire;

        return $this;
    }

    public function getNbreSeancesSemaine(): ?int
    {
        return $this->Nbre_seances_semaine;
    }

    public function setNbreSeancesSemaine(?int $Nbre_seances_semaine): static
    {
        $this->Nbre_seances_semaine = $Nbre_seances_semaine;

        return $this;
    }

    public function getNbreHeureSeance(): ?int
    {
        return $this->Nbre_heure_seance;
    }

    public function setNbreHeureSeance(?int $Nbre_heure_seance): static
    {
        $this->Nbre_heure_seance = $Nbre_heure_seance;

        return $this;
    }

    public function getMontantSeance(): ?int
    {
        return $this->Montant_seance;
    }

    public function setMontantSeance(int $Montant_seance): static
    {
        $this->Montant_seance = $Montant_seance;

        return $this;
    }
}
