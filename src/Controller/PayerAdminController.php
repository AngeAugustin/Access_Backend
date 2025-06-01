<?php

namespace App\Controller;

use App\Entity\Paiement;
use App\Entity\PaiementAdmin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PayerAdminController extends AbstractController
{
    #[Route('/api/payer_admin', name: 'payer_admin', methods: ['POST'])]
    public function payerAdmin(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!$data
            || !isset($data['Id_paiement'], $data['Paiement'], $data['NPI_agent'], $data['Nom_agent'], $data['Prenom_agent'], $data['Role_agent'], $data['Montant_paiement'])) {
            return new JsonResponse(['message' => 'Données manquantes ou invalides'], 400);
        }

        $Id_paiement = $data['Id_paiement'];
        $Paiement = $data['Paiement'];
        $NPI_agent = $data['NPI_agent'];
        $Nom_agent = $data['Nom_agent'];
        $Prenom_agent = $data['Prenom_agent'];
        $Role_agent = $data['Role_agent'];
        $Montant_paiement = $data['Montant_paiement'];

        // Recherche du Paiement
        $paiement = $entityManager->getRepository(Paiement::class)->find($Id_paiement);

        if (!$paiement) {
            return new JsonResponse(['message' => 'Paiement non trouvé'], 404);
        }

        $updated = false;
        $today = new \DateTime();

        // Trouver la correspondance Paiement1, Paiement2 ou Paiement3
        for ($i = 1; $i <= 3; $i++) {
            $getPaiement = 'getPaiement' . $i;
            $setStatut = 'setStatutPaiement' . $i;
            $setDate = 'setDatePaiement' . $i;

            if ($paiement->$getPaiement() === $Paiement) {
                $paiement->$setStatut('Effectué');
                $paiement->$setDate($today);
                $updated = true;
                break;
            }
        }

        if (!$updated) {
            return new JsonResponse(['message' => 'Paiement envoyé ne correspond pas à un Paiement enregistré'], 404);
        }

        $entityManager->persist($paiement);

        // Création enregistrement PaiementAdmin
        $paiementAdmin = new PaiementAdmin();
        $paiementAdmin->setIdPaiement($Paiement);
        $paiementAdmin->setNPIAgent($NPI_agent);
        $paiementAdmin->setNomAgent($Nom_agent);
        $paiementAdmin->setPrenomAgent($Prenom_agent);
        $paiementAdmin->setRoleAgent($Role_agent);
        $paiementAdmin->setStatutPaiement('Effectué');
        $paiementAdmin->setDatePaiement($today->format('Y-m-d'));
        $paiementAdmin->setMontantPaiement($Montant_paiement);

        $entityManager->persist($paiementAdmin);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Paiement parent enregistré avec succès']);
    }
}
