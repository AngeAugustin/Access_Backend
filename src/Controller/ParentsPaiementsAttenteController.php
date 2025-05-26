<?php

namespace App\Controller;

use App\Entity\Paiement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ParentsPaiementsAttenteController extends AbstractController
{
    #[Route('/api/paiements_attente_parent/{NPI_parent}', name: 'paiements_attente_parent', methods: ['GET'])]
    public function paiementsAttente(string $NPI_parent, EntityManagerInterface $entityManager): JsonResponse
    {
        $today = new \DateTime();
        $results = [];

        $paiements = $entityManager->getRepository(Paiement::class)->findBy([
            'NPI_parent' => $NPI_parent
        ]);

        foreach ($paiements as $paiement) {
            for ($i = 1; $i <= 3; $i++) {
                $getDate = 'getDatePaiement' . $i;
                $getStatut = 'getStatutPaiement' . $i;
                $getMontant = 'getMontantPaiement' . $i;

                $date = $paiement->$getDate();
                $statut = $paiement->$getStatut();

                if ($date instanceof \DateTimeInterface && $statut === 'En attente') {
                    $interval = $today->diff($date);
                    $daysDiff = (int) $interval->format('%r%a'); // %r to keep sign

                    if ($daysDiff >= 0 && $daysDiff <= 5) {
                        $results[] = [
                            'NPI_educateur' => $paiement->getNPIEducateur(),
                            'Montant_paiement' => $paiement->$getMontant(),
                            'Date_paiement' => $date->format('Y-m-d'),
                        ];
                    }
                }
            }
        }

        return new JsonResponse($results);
    }
}
