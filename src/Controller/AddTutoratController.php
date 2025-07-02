<?php

namespace App\Controller;

use App\Entity\Paiement;
use App\Entity\Tutorat;
use App\Entity\Tarif;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddTutoratController extends AbstractController
{
    #[Route('/add-tutorat', name: 'add_tutorat', methods: ['POST'])]
    public function addTutorat(Request $request, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        $tutorat = new Tutorat();
        $paiement = new Paiement();

        // Remplir tutorat
        $tutorat->setReferenceTutorat($data['reference_tutorat']);
        $tutorat->setDureeReel($data['duree_reel']);
        // autres setters…

        // Remplir paiement
        $paiement->setIdPaiement(uniqid());
        $paiement->setReferenceTutorat($tutorat->getReferenceTutorat());
        $paiement->setNbrePaiements($data['nbre_paiements']);
        $paiement->setDatePaiement1(new \DateTime($data['date_paiement1'] ?? ''));
        $paiement->setDatePaiement2(new \DateTime($data['date_paiement2'] ?? ''));
        $paiement->setDatePaiement3(new \DateTime($data['date_paiement3'] ?? ''));
        $paiement->setClasseActuelle($data['classe_actuelle']);
        // autres setters si nécessaire…

        // Récupération du tarif
        $tarif = $entityManager->getRepository(Tarif::class)->findOneBy([
            'Classe' => $paiement->getClasseActuelle(),
        ]);

        if (!$tarif) {
            return $this->json(['error' => 'Tarif introuvable pour la classe'], 404);
        }

        // Persist initial
        $entityManager->persist($tutorat);
        $entityManager->persist($paiement);
        $entityManager->flush();

        // ----- LOGIQUE DE CALCUL DES PAIEMENTS -----

        $dureeReel = $tutorat->getDureeReel();
        $tarifHoraire = $tarif->getTarifHoraire();
        $nbHeuresParSeance = $tarif->getNbreHeureSeance();
        $today = new \DateTime();
        $seancesDejaPayees = 0;

        for ($i = 1; $i <= $paiement->getNbrePaiements(); $i++) {
            $getterDate = 'getDatePaiement' . $i;
            $getterMontant = 'getMontantPaiement' . $i;
            $getterSeances = 'getSeancesPaiement' . $i;

            $setterMontant = 'setMontantPaiement' . $i;
            $setterStatut = 'setStatutPaiement' . $i;
            $setterSeances = 'setSeancesPaiement' . $i;

            if (
                method_exists($paiement, $getterDate) &&
                method_exists($paiement, $setterMontant) &&
                method_exists($paiement, $setterSeances) &&
                method_exists($paiement, $setterStatut)
            ) {
                $datePaiement = $paiement->$getterDate();

                if ($datePaiement && $today >= $datePaiement && $paiement->$getterMontant() === null) {
                    $seancesRestantes = $dureeReel - $seancesDejaPayees;

                    if ($seancesRestantes <= 0) {
                        break;
                    }

                    $montant = $seancesRestantes * $nbHeuresParSeance * $tarifHoraire;

                    $paiement->$setterMontant($montant);
                    $paiement->$setterSeances($seancesRestantes);
                    $paiement->$setterStatut('En attente');

                    $seancesDejaPayees += $seancesRestantes;
                } else {
                    $seancesDejaPayees += $paiement->$getterSeances() ?? 0;
                }
            }
        }

        $entityManager->persist($paiement);
        $entityManager->flush();

        return $this->json(['success' => true]);
    }
}

// Foreign key sql syntax
/* ALTER TABLE paiement
ADD CONSTRAINT fk_reference_tutorat FOREIGN KEY (Reference_tutorat)
REFERENCES tutorat (Reference_tutorat)
ON DELETE CASCADE
ON UPDATE CASCADE;
 */