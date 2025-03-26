<?php

namespace App\Controller;

use App\Entity\Seance;
use App\Entity\Enfant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class GetHistoriqueSeancesController extends AbstractController
{
    #[Route('/api/get_historique_seance/{Reference_tutorat}', name: 'api_get_historique', methods: ['GET'])]
    public function getHistoriqueSeances(string $Reference_tutorat, EntityManagerInterface $entityManager): JsonResponse
    {
        // Création de la requête pour récupérer l'historique des séances
        $query = $entityManager->getRepository(Seance::class)->createQueryBuilder('s')
            ->select('s.Id_seance', 's.Date_seance', 's.Heure_seance', 's.Observation', 's.Travail_effectue')
            ->where('s.Reference_tutorat = :Reference_tutorat')
            ->setParameter('Reference_tutorat', $Reference_tutorat)
            ->getQuery();

        // Exécuter la requête pour récupérer tout l'historique
        $historique = $query->getResult();

        // Vérifier si l'historique a été trouvée
        if (empty($historique)) {
            return $this->json([
                'message' => 'Aucun historique trouvé pour cette relation de tutorat ' . $Reference_tutorat,
                'status' => JsonResponse::HTTP_NOT_FOUND
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        // Retourner les détails au format JSON
        return $this->json([
            'status' => JsonResponse::HTTP_OK,
            'data' => $historique
        ], JsonResponse::HTTP_OK);
    }
}
