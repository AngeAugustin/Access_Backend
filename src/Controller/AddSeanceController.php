<?php

namespace App\Controller;

use App\Entity\Seance;
use App\Entity\Tutorat;
use App\Entity\Paiement;
use App\Entity\Tarif;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AddSeanceController extends AbstractController
{
    #[Route('/api/add_seance', name: 'api_add_seance', methods: ['POST'])]
public function apiAddSeance(Request $request, EntityManagerInterface $entityManager): JsonResponse
{  
    $data = json_decode($request->getContent(), true);

    if ($data === null) {
        return new JsonResponse(['error' => 'Invalid JSON format'], Response::HTTP_BAD_REQUEST);
    }

    // Vérification de l'existence de l'ID séance
    $existingID = $entityManager->getRepository(Seance::class)->findOneBy(['Id_seance' => $data['Id_seance']]);
    if ($existingID) {
        return new JsonResponse(['error' => 'Cette séance a déjà été validée.'], Response::HTTP_BAD_REQUEST);
    }

    // Requête avec jointure explicite
    $qb = $entityManager->createQueryBuilder();
    $qb->select('t')
       ->from('App\Entity\Tutorat', 't')
       ->where('t.Reference_tutorat = :ref')
       ->setParameter('ref', $data['Reference_tutorat']);

    $tutorat = $qb->getQuery()->getOneOrNullResult();

    if (!$tutorat) {
        return new JsonResponse(['error' => 'La référence de tutorat est invalide.'], Response::HTTP_BAD_REQUEST);
    }

    // Incrémentation de la durée réelle
    $tutorat->setDureeReel($tutorat->getDureeReel() + 1);

    // Recalcul des montants de paiement
    $this->recalculerMontantsPaiement($tutorat, $entityManager);

    // Création et enregistrement de la séance
    $seance = new Seance();
    $seance->setIdSeance($data['Id_seance']);
    $seance->setReferenceTutorat($data['Reference_tutorat']);
    $seance->setDateSeance(new \DateTime());
    $seance->setHeureSeance($data['Heure_seance']);
    $seance->setObservation($data['Observation']);
    $seance->setTravailEffectue($data['Travail_effectue']);
    $seance->setNPIEducateur($data['NPI_educateur']);
    $seance->setNPIEnfant($data['NPI_enfant']);

    $entityManager->persist($seance);
    $entityManager->persist($tutorat); // Important pour que la mise à jour soit prise en compte
    $entityManager->flush();

    return new JsonResponse([
        'Message' => 'Séance ajoutée avec succès',
        'Id_seance' => $seance->getIdSeance()
    ]);
}

    /**
     * Recalcule les montants de paiement en fonction de la durée réelle
     */
    private function recalculerMontantsPaiement(Tutorat $tutorat, EntityManagerInterface $entityManager): void
    {
        // Récupération du paiement associé au tutorat
        $paiement = $entityManager->getRepository(Paiement::class)->findOneBy([
            'Reference_tutorat' => $tutorat->getReferenceTutorat()
        ]);

        if (!$paiement) {
            return; // Pas de paiement trouvé, on sort
        }

        // Récupération du tarif pour les calculs
        $tarif = $entityManager->getRepository(Tarif::class)->findOneBy([
            'Classe_actuelle' => $paiement->getClasseActuelle()
        ]);

        if (!$tarif) {
            return; // Pas de tarif trouvé, on sort
        }

        // Variables pour les calculs
        $dureeReel = $tutorat->getDureeReel();
        $dureeTutorat = (int) $tutorat->getDureeTutorat();
        $nbreSeancesSemaine = $tarif->getNbreSeancesSemaine();
        $nbreHeureSeance = $tarif->getNbreHeureSeance();
        $tarifHoraire = $tarif->getTarifHoraire();
        $nbrePaiements = $paiement->getNbrePaiements();

        // Recalcul des montants selon le nombre de paiements
        if ($nbrePaiements == 1) {
            // Un seul paiement
            $dureePourPaiement = min($dureeReel, $dureeTutorat);
            $montant = $nbreHeureSeance * $nbreSeancesSemaine * $dureePourPaiement * $tarifHoraire;
            
            $paiement->setMontantPaiement1($montant);
            $paiement->setSeancesPaiement1($dureePourPaiement);
        } else {
            // Paiements multiples
            $seancesUtilisees = 0;
            
            for ($i = 1; $i <= $nbrePaiements && $i <= 3; $i++) {
                $dureePourCePaiement = min(4, max(0, $dureeReel - $seancesUtilisees));
                $montant = $nbreHeureSeance * $nbreSeancesSemaine * $dureePourCePaiement * $tarifHoraire;
                $seancesUtilisees += $dureePourCePaiement;

                // Construction dynamique des noms de méthodes
                $setMontant = "setMontantPaiement$i";
                $setSeances = "setSeancesPaiement$i";

                // Vérification et appel des méthodes
                if (method_exists($paiement, $setMontant) && method_exists($paiement, $setSeances)) {
                    $paiement->$setMontant($montant);
                    $paiement->$setSeances($dureePourCePaiement);
                }
            }
        }

        // Sauvegarde des modifications
        $entityManager->persist($paiement);
    }

}
