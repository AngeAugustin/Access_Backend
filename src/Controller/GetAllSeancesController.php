<?php

namespace App\Controller;

use App\Entity\Seance;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class GetAllSeancesController extends AbstractController
{
    #[Route('/api/get_all_seances', name: 'api_get_all_seances', methods: ['GET'])]
    public function getAllSeances(EntityManagerInterface $entityManager): JsonResponse
    {
        // Création d'une requête avec jointures
        $seances = $entityManager->getRepository(Seance::class)->createQueryBuilder('s')
            ->select(
                's.Id_seance',
                'educateur.Name AS educateur_nom',
                'educateur.Firstname AS educateur_prenom',
                'enfant.Nom_enfant',
                'enfant.Prenom_enfant',
                's.Heure_seance'
            )
            ->leftJoin('s.NPI_educateur', 'educateur')
            ->leftJoin('s.NPI_enfant', 'enfant')
            ->getQuery()
            ->getResult();

        // Vérification si des séances ont été trouvées
        if (empty($seances)) {
            return $this->json(['message' => 'Aucune séance trouvée'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Retourner les séances sous format JSON
        return $this->json($seances, JsonResponse::HTTP_OK);
    }
}
