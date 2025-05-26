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
        $enAttente = [];
        $effectues = [];

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

                if ($date instanceof \DateTimeInterface) {
                    // Paiement en attente, dans 5 jours ou moins
                    if ($statut === 'En attente') {
                        $interval = $today->diff($date);
                        $daysDiff = (int) $interval->format('%r%a');
                        if ($daysDiff >= 0 && $daysDiff <= 5) {
                            $enAttente[] = [
                                'NPI_educateur' => $paiement->getNPIEducateur(),
                                'Montant_paiement' => $paiement->$getMontant(),
                                'Statut_paiement' => $paiement->$getStatut(),
                                'Date_paiement' => $date->format('Y-m-d'),
                            ];
                        }
                    }

                    // Paiement effectué, sans contrainte de date
                    if ($statut === 'Effectué') {
                        $effectues[] = [
                            'NPI_educateur' => $paiement->getNPIEducateur(),
                            'Montant_paiement' => $paiement->$getMontant(),
                            'Date_paiement' => $date->format('Y-m-d'),
                        ];
                    }
                }
            }
        }

        return new JsonResponse([
            'en_attente' => $enAttente,
            'effectues' => $effectues
        ]);
    }
}
