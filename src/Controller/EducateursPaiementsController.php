<?php

namespace App\Controller;

use App\Entity\Paiement;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class EducateursPaiementsController extends AbstractController
{
    #[Route('/api/paiements_educateur/{NPI_educateur}', name: 'paiements_educateur', methods: ['GET'])]
    public function paiementsEffectues(string $NPI_educateur, EntityManagerInterface $entityManager): JsonResponse
    {
        $paiements = $entityManager->getRepository(Paiement::class)->findBy([
            'NPI_educateur' => $NPI_educateur
        ]);

        $resultats = [];

        foreach ($paiements as $paiement) {
            $userParent = $entityManager->getRepository(User::class)->findOneBy([
                'NPI' => $paiement->getNPIParent()
            ]);

            $nom = $userParent?->getName() ?? 'Inconnu';
            $prenom = $userParent?->getFirstname() ?? 'Inconnu';

            for ($i = 1; $i <= 3; $i++) {
                $getDate = 'getDatePaiement' . $i;
                $getStatut = 'getStatutPaiement' . $i;
                $getMontant = 'getMontantPaiement' . $i;

                $date = $paiement->$getDate();
                $statut = $paiement->$getStatut();

                if ($date instanceof \DateTimeInterface && $statut === 'Effectué') {
                    $resultats[] = [
                        'Id_paiement' => $paiement->getIdPaiement(),
                        'Parent_nom' => $nom,
                        'Parent_prenom' => $prenom,
                        'Montant_paiement' => $paiement->$getMontant(),
                        'Statut_paiement' => $statut,
                        'Date_paiement' => $date->format('Y-m-d')
                    ];
                }
            }
        }

        // Trier du plus récent au plus ancien
        usort($resultats, function ($a, $b) {
            return strtotime($b['Date_paiement']) - strtotime($a['Date_paiement']);
        });

        // Limiter aux 10 plus récents
        $resultats = array_slice($resultats, 0, 10);

        return new JsonResponse($resultats);
    }
}
