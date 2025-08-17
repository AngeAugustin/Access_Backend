<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class StopTutoratController extends AbstractController
{
    #[Route('/api/stop_tutorat', name: 'api_stop_tutorat', methods: ['POST'])]
    public function stopTutorat(\Symfony\Component\HttpFoundation\Request $request, \Doctrine\ORM\EntityManagerInterface $entityManager): \Symfony\Component\HttpFoundation\JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $reference = $data['Reference_tutorat'] ?? null;
        if (!$reference) {
            return $this->json(['error' => 'Reference_tutorat manquant'], 400);
        }

        $tutorat = $entityManager->getRepository(\App\Entity\Tutorat::class)->findOneBy(['Reference_tutorat' => $reference]);
        if (!$tutorat) {
            return $this->json(['error' => 'Tutorat non trouvé'], 404);
        }

        $tutorat->setStatutTutorat('Terminé');
        $tutorat->setDateFinTutorat(new \DateTime());

        // Paiements associés
        $paiement = $entityManager->getRepository(\App\Entity\Paiement::class)->findOneBy(['Reference_tutorat' => $reference]);
        $dateArret = new \DateTime();
        $paiementsModifies = [];
        if ($paiement) {
            $nbrePaiements = $paiement->getNbrePaiements();
            $prochainIndex = null;
            $prochaineDate = null;
            // Trouver le paiement "En attente" avec la date la plus proche >= date d'arrêt
            for ($i = 1; $i <= $nbrePaiements; $i++) {
                $getStatut = "getStatutPaiement$i";
                $getDate = "getDatePaiement$i";
                $statut = $paiement->$getStatut();
                $datePaiement = $paiement->$getDate();
                if ($statut === 'En attente' && $datePaiement instanceof \DateTimeInterface) {
                    if ($datePaiement >= $dateArret) {
                        if ($prochaineDate === null || $datePaiement < $prochaineDate) {
                            $prochaineDate = $datePaiement;
                            $prochainIndex = $i;
                        }
                    }
                }
            }
            // Mettre à jour les paiements
            for ($i = 1; $i <= $nbrePaiements; $i++) {
                $getStatut = "getStatutPaiement$i";
                $setStatut = "setStatutPaiement$i";
                $getDate = "getDatePaiement$i";
                $setDate = "setDatePaiement$i";
                $statut = $paiement->$getStatut();
                if ($statut === 'En attente') {
                    if ($prochainIndex !== null && $i === $prochainIndex) {
                        $paiement->$setStatut('Effectué');
                        $paiement->$setDate($dateArret);
                        $paiementsModifies[] = [
                            'index' => $i,
                            'statut' => 'Effectué',
                            'date_paiement' => $dateArret->format('Y-m-d'),
                        ];
                    } else {
                        $paiement->$setStatut('Suspendu');
                        $paiement->$setDate($dateArret);
                        $paiementsModifies[] = [
                            'index' => $i,
                            'statut' => 'Suspendu',
                            'date_paiement' => $dateArret->format('Y-m-d'),
                        ];
                    }
                }
            }
        }

        $entityManager->flush();

        return $this->json([
            'message' => 'Tutorat arrêté avec succès',
            'Reference_tutorat' => $reference,
            'Statut_tutorat' => $tutorat->getStatutTutorat(),
            'Date_fin_tutorat' => $tutorat->getDateFinTutorat()?->format('Y-m-d'),
            'paiements_modifies' => $paiementsModifies,
        ]);
    }
}
