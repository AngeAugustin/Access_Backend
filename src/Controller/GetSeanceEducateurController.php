<?php

namespace App\Controller;

use App\Entity\Seance;
use App\Entity\Enfant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class GetSeanceEducateurController extends AbstractController
{
    #[Route('/api/get_seance/{NPI_educateur}', name: 'api_get_seance_educateur', methods: ['GET'])]
    public function getSeanceEducateur(string $NPI_educateur, EntityManagerInterface $entityManager): JsonResponse
    {
        // Création de la requête pour récupérer toutes les séances de l'éducateur
        $query = $entityManager->getRepository(Seance::class)->createQueryBuilder('t')
            ->select('s.Id_seance', 's.Date_seance', 'e.Nom_enfant', 'e.Prenom_enfant', 's.NPI_enfant')
            ->leftJoin(Enfant::class, 'e', 'WITH', 'e.NPI_enfant = t.NPI_enfant')
            ->where('t.NPI_educateur = :NPI_educateur')
            ->setParameter('NPI_educateur', $NPI_educateur)
            ->getQuery();

        // Exécuter la requête pour récupérer toutes les séances
        $seances = $query->getResult();

        // Vérifier si des séances ont été trouvées
        if (empty($seances)) {
            return $this->json([
                'message' => 'Aucune séance trouvé pour cet éducateur ' . $NPI_educateur,
                'status' => JsonResponse::HTTP_NOT_FOUND
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        // Retourner les séances au format JSON
        return $this->json([
            'status' => JsonResponse::HTTP_OK,
            'data' => $seances
        ], JsonResponse::HTTP_OK);
    }
}
