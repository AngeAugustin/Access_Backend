<?php

namespace App\Controller;

use App\Entity\Tutorat;
use App\Entity\Paiement;
use App\Entity\Tarif;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\ByteString;

final class AddTutoratController extends AbstractController
{
    #[Route('/api/add_tutorat', name: 'api_add_tutorat', methods: ['POST'])]
    public function apiAddTutorat(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        // Vérification des disponibilités libres de l'éducateur
        $data = json_decode($request->getContent(), true);
        $educateur = $entityManager->getRepository(\App\Entity\Educateur::class)->findOneBy(['NPI' => $data['NPI_educateur']]);
        if (!$educateur) {
            return new JsonResponse(['error' => "Éducateur non trouvé"], Response::HTTP_BAD_REQUEST);
        }

        // Récupérer toutes ses disponibilités
        $dispos = [];
        foreach ([1,2,3,4] as $i) {
            $dispo = $educateur->{"getDispo$i"}();
            if ($dispo) $dispos[] = $dispo;
        }

        // Récupérer toutes les séances de l'éducateur dans les tutorats non terminés
        $tutoratsEnCours = $entityManager->getRepository(\App\Entity\Tutorat::class)->findBy([
            'NPI_educateur' => $data['NPI_educateur'],
            'Statut_tutorat' => 'En cours'
        ]);
        $seancesOccupees = [];
        foreach ($tutoratsEnCours as $tut) {
            if ($tut->getSeance1()) $seancesOccupees[] = $tut->getSeance1();
            if ($tut->getSeance2()) $seancesOccupees[] = $tut->getSeance2();
        }

        // Disponibilités libres = toutes - occupées
        $disposLibres = array_diff($dispos, $seancesOccupees);

        // Si l'éducateur a des tutorats en cours, il doit avoir au moins 2 dispos libres
        if (count($tutoratsEnCours) > 0 && count($disposLibres) < 2) {
            return new JsonResponse(['error' => "L'éducateur n'a pas assez de disponibilités libres (minimum 2) pour accepter un nouveau tutorat."], Response::HTTP_BAD_REQUEST);
        }
    {
        $data = json_decode($request->getContent(), true);

        if ($data === null) {
            return new JsonResponse(['error' => 'Invalid JSON format'], Response::HTTP_BAD_REQUEST);
        }

        // Vérifie si une référence existe déjà
        $existingReference = $entityManager->getRepository(Tutorat::class)->findOneBy([
            'Reference_tutorat' => $data['Reference_tutorat']
        ]);
        if ($existingReference) {
            return new JsonResponse(['error' => 'Une relation de tutorat avec la même référence existe déjà'], Response::HTTP_BAD_REQUEST);
        }

        // Vérifie la présence du tarif pour la classe actuelle
        $tarif = $entityManager->getRepository(Tarif::class)->findOneBy([
            'Classe_actuelle' => $data['Classe_actuelle']
        ]);

        if (!$tarif) {
            return new JsonResponse(['error' => 'Tarif non défini pour la classe actuelle'], Response::HTTP_BAD_REQUEST);
        }

        // Enregistrement dans Tutorat
        $tutorat = new Tutorat();
        $tutorat->setReferenceTutorat($data['Reference_tutorat']);
        $tutorat->setNPIParent($data['NPI_parent']);
        $tutorat->setNPIEducateur($data['NPI_educateur']);
        $tutorat->setNPIEnfant($data['NPI_enfant']);
        $tutorat->setDureeTutorat($data['Duree_tutorat']);
        $tutorat->setSeance1($data['Seance1']);
        $tutorat->setSeance2($data['Seance2']);
        $tutorat->setStatutTutorat('En cours');

        $tutorat->setDateTutorat(new \DateTime());
        $dateDebut = new \DateTime();
        $duree = $tutorat->getDureeTutorat(); // en semaines

        // Calcul de la date de fin
        $dateFin = (clone $dateDebut)->modify("+{$duree} weeks");
        $tutorat->setDateFinTutorat($dateFin);

        $today = new \DateTime();
        if ($today->format('Y-m-d') >= $dateFin->format('Y-m-d')) {
            $tutorat->setStatutTutorat('Terminé');
        }

        $entityManager->persist($tutorat);
        $entityManager->flush();

        // Calculs liés au tarif
        $Nbre_seances_semaine = $tarif->getNbreSeancesSemaine();
        $Nbre_heure_seance = $tarif->getNbreHeureSeance();
        $Tarif_horaire = $tarif->getTarifHoraire();
        $Duree_tutorat = $data['Duree_tutorat'];
        $Classe_actuelle = $data['Classe_actuelle'];

        $paiement = new Paiement();
        $paiement->setIdPaiement(random_int(1000000000, 9999999999));
        $paiement->setReferenceTutorat($data['Reference_tutorat']);
        $paiement->setNPIParent($data['NPI_parent']);
        $paiement->setNPIEducateur($data['NPI_educateur']);
        $paiement->setDureeTutorat($Duree_tutorat);
        $paiement->setClasseActuelle($Classe_actuelle);

        $dateBase = new \DateTime();
        $statut = 'En attente';

        // Pour la création initiale, on utilise la durée prévue du tutorat
        // Les montants seront recalculés automatiquement dans AddSeanceController selon la durée réelle
        if ($Duree_tutorat <= 4) {
            $paiement->setNbrePaiements(1);
            $dureePourPaiement = $Duree_tutorat; // Utilise la durée prévue initialement
            $montant = $Nbre_heure_seance * $Nbre_seances_semaine * $dureePourPaiement * $Tarif_horaire;

            $paiement->setMontantPaiement1($montant);
            $paiement->setStatutPaiement1($statut);
            $paiement->setDatePaiement1((clone $dateBase)->modify('+1 month'));
            $paiement->setPaiement1(ByteString::fromRandom(8)->toString());
            $paiement->setSeancesPaiement1($dureePourPaiement);
        } else {
            $nbrePaiements = intval(ceil($Duree_tutorat / 4));
            $paiement->setNbrePaiements($nbrePaiements);

            $seancesUtilisees = 0;
            $currentDate = clone $dateBase;

            for ($i = 1; $i <= $nbrePaiements; $i++) {
                $currentDate->modify('+1 month');

                $dureePourCePaiement = min(4, max(0, $Duree_tutorat - $seancesUtilisees)); // Utilise la durée prévue initialement
                $montant = $Nbre_heure_seance * $Nbre_seances_semaine * $dureePourCePaiement * $Tarif_horaire;
                $seancesUtilisees += $dureePourCePaiement;

                $suffix = $i;
                $setters = [
                    'Montant'  => "setMontantPaiement$suffix",
                    'Statut'   => "setStatutPaiement$suffix",
                    'Date'     => "setDatePaiement$suffix",
                    'Token'    => "setPaiement$suffix",
                    'Seances'  => "setSeancesPaiement$suffix"
                ];

                if (
                    method_exists($paiement, $setters['Montant']) &&
                    method_exists($paiement, $setters['Statut']) &&
                    method_exists($paiement, $setters['Date']) &&
                    method_exists($paiement, $setters['Token']) &&
                    method_exists($paiement, $setters['Seances'])
                ) {
                    $paiement->{$setters['Montant']}($montant);
                    $paiement->{$setters['Statut']}($statut);
                    $paiement->{$setters['Date']}(clone $currentDate);
                    $paiement->{$setters['Token']}(ByteString::fromRandom(8)->toString());
                    $paiement->{$setters['Seances']}($dureePourCePaiement);
                }
            }
        }

        $entityManager->persist($paiement);
        $entityManager->flush();

        return new JsonResponse([
            'Message' => 'Relation de tutorat créée avec succès',
            'Reference_tutorat' => $tutorat->getReferenceTutorat()
        ]);
    }
}

// NOTE: Les montants de paiement sont initialement calculés avec la durée prévue du tutorat.
// Ils seront automatiquement recalculés en fonction de la durée réelle à chaque ajout de séance
// dans AddSeanceController grâce à la méthode recalculerMontantsPaiement().

// Forign key sql syntax
/* ALTER TABLE paiement
ADD CONSTRAINT fk_reference_tutorat FOREIGN KEY (Reference_tutorat)
REFERENCES tutorat (Reference_tutorat)
ON DELETE CASCADE
*/

}
ON UPDATE CASCADE;
 */