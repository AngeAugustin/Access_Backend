<?php

namespace App\Controller;

use App\Entity\PaiementAdmin;
use App\Entity\PaiementParent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DetailsPaiementController extends AbstractController
{
    #[Route('/api/details/paiement/{id}/{role}', name: 'details_paiement_by_id_role', methods: ['GET'])]
    public function getDetailsPaiement(string $id, string $role, EntityManagerInterface $entityManager): JsonResponse
    {
        
        if ($role === 'Admin') {
            $paiement = $entityManager->getRepository(PaiementAdmin::class)->findOneBy(['Id_paiement' => $id]);
            if (!$paiement) {
                return new JsonResponse(['error' => 'Paiement non trouvé'], 404);
            }
            return new JsonResponse([
                'Id_paiement' => $paiement->getIdPaiement(),
                'Id_transaction' => $paiement->getIdTransaction(),
                'NPI_agent' => $paiement->getNpiAgent(),
                'Nom_agent' => $paiement->getNomAgent(),
                'Prenom_agent' => $paiement->getPrenomAgent(),
                'Email_agent' => $paiement->getEmailAgent(),
                'Montant_paiement' => $paiement->getMontantPaiement(),
                'Date_paiement' => $paiement->getDatePaiement(),
                'Statut_paiement' => $paiement->getStatutPaiement(),
                'Role' => $paiement->getRoleAgent(),
            ]); 
        } elseif ($role === 'PARENT') {
            $paiement = $entityManager->getRepository(PaiementParent::class)->findOneBy(['Id_paiement' => $id]);
            if (!$paiement) {
                return new JsonResponse(['error' => 'Paiement non trouvé'], 404);
            }
            return new JsonResponse([
                'Id_paiement' => $paiement->getIdPaiement(),
                'Id_transaction' => $paiement->getIdTransaction(),
                'NPI_payeur' => $paiement->getNpiPayeur(),
                'Nom_payeur' => $paiement->getNomPayeur(),
                'Prenom_payeur' => $paiement->getPrenomPayeur(),
                'Email_payeur' => $paiement->getEmailPayeur(), 
                'Montant_paiement' => $paiement->getMontantPaiement(),
                'Date_paiement' => $paiement->getDatePaiement(),
                'Statut_paiement' => $paiement->getStatutPaiement(),
                'Role' => $paiement->getRolePayeur(),
            ]);
        } else {
            return new JsonResponse(['error' => 'Role inconnu'], 400);
        }
    }
}
