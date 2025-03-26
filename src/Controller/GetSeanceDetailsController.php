<?php

namespace App\Controller;

use App\Entity\Seance;
use App\Entity\Enfant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class GetSeanceDetailsController extends AbstractController
{
    #[Route('/api/get_seance_details/{Id_seance}', name: 'api_get_seance_details', methods: ['GET'])]
    public function getSeanceDetails(string $Id_seance, EntityManagerInterface $entityManager): JsonResponse
    {
        // Création de la requête pour récupérer toutes les détails d'une séance
        $query = $entityManager->getRepository(Seance::class)->createQueryBuilder('s')
            ->select('s.Id_seance', 's.Date_seance', 's.Heure_seance', 's.Observation', 's.Travail_effectue', 'e.Nom_enfant', 'e.Prenom_enfant', 'e.Classe_actuelle')
            ->leftJoin(Enfant::class, 'e', 'WITH', 'e.NPI_enfant = s.NPI_enfant')
            ->where('s.Id_seance = :Id_seance')
            ->setParameter('Id_seance', $Id_seance)
            ->getQuery();

        // Exécuter la requête pour récupérer toutes les séances
        $details = $query->getResult();

        // Vérifier si les détails ont été trouvées
        if (empty($details)) {
            return $this->json([
                'message' => 'Aucune détail trouvé pour cette séance ' . $Id_seance,
                'status' => JsonResponse::HTTP_NOT_FOUND
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        // Retourner les détails au format JSON
        return $this->json([
            'status' => JsonResponse::HTTP_OK,
            'data' => $details
        ], JsonResponse::HTTP_OK);
    }
}
