<?php

namespace App\Controller;

use App\Entity\Seance;
use App\Entity\Enfant;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class GetAllSeancesController extends AbstractController
{
    #[Route('/api/get_all_seances', name: 'api_get_all_seances', methods: ['GET'])]
    public function getAllSeances(EntityManagerInterface $entityManager): JsonResponse
    {
        // Récupération des séances avec jointures
        $seances = $entityManager->getRepository(Seance::class)
            ->createQueryBuilder('s')
            ->select(
                's.Id_seance',
                'e.Nom_enfant AS NomEnfant',
                'e.Prenom_enfant AS PrenomEnfant',
                'u.Name AS NomEducateur',
                'u.Firstname AS PrenomEducateur',
                's.Heure_seance'
            )
            ->leftJoin(Enfant::class, 'e', 'WITH', 's.NPI_enfant = e.NPI_enfant')
            ->leftJoin(User::class, 'u', 'WITH', 's.NPI_educateur = u.NPI')
            ->getQuery()
            ->getResult();

        // Vérification si aucune séance n'est trouvée
        if (empty($seances)) {
            return $this->json(['message' => 'Aucune séance trouvée'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Retourner les séances sous format JSON
        return $this->json($seances, JsonResponse::HTTP_OK);
    }
}
