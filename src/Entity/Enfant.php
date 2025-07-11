<?php

namespace App\Entity;

use App\Repository\EnfantRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EnfantRepository::class)]
class Enfant
{
    #[ORM\Id]
    #[ORM\Column(length: 20)]
    private ?string $NPI_enfant = null;

    #[ORM\Column(length: 200)]
    private ?string $Nom_enfant = null;

    #[ORM\Column(length: 200)]
    private ?string $Prenom_enfant = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $Date_naissance = null;

    #[ORM\Column(length: 5)]
    private ?string $Sexe_enfant = null;

    #[ORM\Column(length: 20)]
    private ?string $Classe_precedente = null;

    #[ORM\Column(length: 20)]
    private ?string $Ecole_precedente = null;

    #[ORM\Column(length: 200)]
    private ?string $Classe_actuelle = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Ecole_actuelle = null;

    #[ORM\Column(length: 200)]
    private ?string $Parent_tuteur = null;

    #[ORM\Column(length: 240, nullable: true)]
    private ?string $Matieres_preferes = null;

    #[ORM\Column(length: 245, nullable: true)]
    private ?string $Centre_interet = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Niveau_francais = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Niveau_anglais = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Niveau_philosophie = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Niveau_mathematique = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Niveau_svt = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Niveau_pct = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Niveau_histgeo = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Niveau_allemand = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Niveau_espagnol = null;

    #[ORM\Column(length: 20)]
    private ?string $NPI = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Niveau_economie = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Niveau_comptabilite = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Niveau_comptagenerale = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Niveau_comptaanalytique = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Niveau_comptasociete = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Niveau_comptausuelle = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Niveau_TA = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Niveau_mathsfinanciere = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Niveau_droit = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Niveau_mathsgenerale = null;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $Niveau_fiscalite = null;

    public function getNPIEnfant(): ?string
    {
        return $this->NPI_enfant;
    }

    public function setNPIEnfant(string $NPI_enfant): static
    {
        $this->NPI_enfant = $NPI_enfant;

        return $this;
    }

    public function getNomEnfant(): ?string
    {
        return $this->Nom_enfant;
    }

    public function setNomEnfant(string $Nom_enfant): static
    {
        $this->Nom_enfant = $Nom_enfant;

        return $this;
    }

    public function getPrenomEnfant(): ?string
    {
        return $this->Prenom_enfant;
    }

    public function setPrenomEnfant(string $Prenom_enfant): static
    {
        $this->Prenom_enfant = $Prenom_enfant;

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

    public function getSexeEnfant(): ?string
    {
        return $this->Sexe_enfant;
    }

    public function setSexeEnfant(string $Sexe_enfant): static
    {
        $this->Sexe_enfant = $Sexe_enfant;

        return $this;
    }

    public function getClassePrecedente(): ?string
    {
        return $this->Classe_precedente;
    }

    public function setClassePrecedente(string $Classe_precedente): static
    {
        $this->Classe_precedente = $Classe_precedente;

        return $this;
    }

    public function getEcolePrecedente(): ?string
    {
        return $this->Ecole_precedente;
    }

    public function setEcolePrecedente(string $Ecole_precedente): static
    {
        $this->Ecole_precedente = $Ecole_precedente;

        return $this;
    }

    public function getClasseActuelle(): ?string
    {
        return $this->Classe_actuelle;
    }

    public function setClasseActuelle(string $Classe_actuelle): static
    {
        $this->Classe_actuelle = $Classe_actuelle;

        return $this;
    }

    public function getEcoleActuelle(): ?string
    {
        return $this->Ecole_actuelle;
    }

    public function setEcoleActuelle(?string $Ecole_actuelle): static
    {
        $this->Ecole_actuelle = $Ecole_actuelle;

        return $this;
    }

    public function getParentTuteur(): ?string
    {
        return $this->Parent_tuteur;
    }

    public function setParentTuteur(string $Parent_tuteur): static
    {
        $this->Parent_tuteur = $Parent_tuteur;

        return $this;
    }

    public function getMatieresPreferes(): ?string
    {
        return $this->Matieres_preferes;
    }

    public function setMatieresPreferes(?string $Matieres_preferes): static
    {
        $this->Matieres_preferes = $Matieres_preferes;

        return $this;
    }

    public function getCentreInteret(): ?string
    {
        return $this->Centre_interet;
    }

    public function setCentreInteret(?string $Centre_interet): static
    {
        $this->Centre_interet = $Centre_interet;

        return $this;
    }

    public function getNiveauFrancais(): ?string
    {
        return $this->Niveau_francais;
    }

    public function setNiveauFrancais(string $Niveau_francais): static
    {
        $this->Niveau_francais = $Niveau_francais;

        return $this;
    }

    public function getNiveauAnglais(): ?string
    {
        return $this->Niveau_anglais;
    }

    public function setNiveauAnglais(string $Niveau_anglais): static
    {
        $this->Niveau_anglais = $Niveau_anglais;

        return $this;
    }

    public function getNiveauPhilosophie(): ?string
    {
        return $this->Niveau_philosophie;
    }

    public function setNiveauPhilosophie(string $Niveau_philosophie): static
    {
        $this->Niveau_philosophie = $Niveau_philosophie;

        return $this;
    }

    public function getNiveauMathematique(): ?string
    {
        return $this->Niveau_mathematique;
    }

    public function setNiveauMathematique(string $Niveau_mathematique): static
    {
        $this->Niveau_mathematique = $Niveau_mathematique;

        return $this;
    }

    public function getNiveauSvt(): ?string
    {
        return $this->Niveau_svt;
    }

    public function setNiveauSvt(string $Niveau_svt): static
    {
        $this->Niveau_svt = $Niveau_svt;

        return $this;
    }

    public function getNiveauPct(): ?string
    {
        return $this->Niveau_pct;
    }

    public function setNiveauPct(string $Niveau_pct): static
    {
        $this->Niveau_pct = $Niveau_pct;

        return $this;
    }

    public function getNiveauHistgeo(): ?string
    {
        return $this->Niveau_histgeo;
    }

    public function setNiveauHistgeo(string $Niveau_histgeo): static
    {
        $this->Niveau_histgeo = $Niveau_histgeo;

        return $this;
    }

    public function getNiveauAllemand(): ?string
    {
        return $this->Niveau_allemand;
    }

    public function setNiveauAllemand(?string $Niveau_allemand): static
    {
        $this->Niveau_allemand = $Niveau_allemand;

        return $this;
    }

    public function getNiveauEspagnol(): ?string
    {
        return $this->Niveau_espagnol;
    }

    public function setNiveauEspagnol(?string $Niveau_espagnol): static
    {
        $this->Niveau_espagnol = $Niveau_espagnol;

        return $this;
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

    public function getNiveauEconomie(): ?string
    {
        return $this->Niveau_economie;
    }

    public function setNiveauEconomie(?string $Niveau_economie): static
    {
        $this->Niveau_economie = $Niveau_economie;

        return $this;
    }

    public function getNiveauComptabilite(): ?string
    {
        return $this->Niveau_comptabilite;
    }

    public function setNiveauComptabilite(?string $Niveau_comptabilite): static
    {
        $this->Niveau_comptabilite = $Niveau_comptabilite;

        return $this;
    }

    public function getNiveauComptagenerale(): ?string
    {
        return $this->Niveau_comptagenerale;
    }

    public function setNiveauComptagenerale(?string $Niveau_comptagenerale): static
    {
        $this->Niveau_comptagenerale = $Niveau_comptagenerale;

        return $this;
    }

    public function getNiveauComptaanalytique(): ?string
    {
        return $this->Niveau_comptaanalytique;
    }

    public function setNiveauComptaanalytique(?string $Niveau_comptaanalytique): static
    {
        $this->Niveau_comptaanalytique = $Niveau_comptaanalytique;

        return $this;
    }

    public function getNiveauComptasociete(): ?string
    {
        return $this->Niveau_comptasociete;
    }

    public function setNiveauComptasociete(?string $Niveau_comptasociete): static
    {
        $this->Niveau_comptasociete = $Niveau_comptasociete;

        return $this;
    }

    public function getNiveauComptausuelle(): ?string
    {
        return $this->Niveau_comptausuelle;
    }

    public function setNiveauComptausuelle(?string $Niveau_comptausuelle): static
    {
        $this->Niveau_comptausuelle = $Niveau_comptausuelle;

        return $this;
    }

    public function getNiveauTA(): ?string
    {
        return $this->Niveau_TA;
    }

    public function setNiveauTA(?string $Niveau_TA): static
    {
        $this->Niveau_TA = $Niveau_TA;

        return $this;
    }

    public function getNiveauMathsfinanciere(): ?string
    {
        return $this->Niveau_mathsfinanciere;
    }

    public function setNiveauMathsfinanciere(?string $Niveau_mathsfinanciere): static
    {
        $this->Niveau_mathsfinanciere = $Niveau_mathsfinanciere;

        return $this;
    }

    public function getNiveauDroit(): ?string
    {
        return $this->Niveau_droit;
    }

    public function setNiveauDroit(?string $Niveau_droit): static
    {
        $this->Niveau_droit = $Niveau_droit;

        return $this;
    }

    public function getNiveauMathsgenerale(): ?string
    {
        return $this->Niveau_mathsgenerale;
    }

    public function setNiveauMathsgenerale(?string $Niveau_mathsgenerale): static
    {
        $this->Niveau_mathsgenerale = $Niveau_mathsgenerale;

        return $this;
    }

    public function getNiveauFiscalite(): ?string
    {
        return $this->Niveau_fiscalite;
    }

    public function setNiveauFiscalite(?string $Niveau_fiscalite): static
    {
        $this->Niveau_fiscalite = $Niveau_fiscalite;

        return $this;
    }
}
