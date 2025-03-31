<?php

namespace App\Controller;

use App\Entity\Seance;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
final class GetAllSeancesController extends AbstractController
{
    #[Route('/api/get_all_seances', name: 'api_get_all_seances', methods: ['GET'])]
    public function getAllSeances(EntityManagerInterface $entityManager): JsonResponse
    {
        // Récupération des seances avec une validation de la requête
        $seances = $entityManager->getRepository(Seance::class)->createQueryBuilder('s')
            ->select('s.Id_seance, s.NPI_educateur, s.NPI_enfant, s.Heure_seance')
            ->getQuery()
            ->getResult();

        // Si aucune séance n'est trouvé
        if (empty($seances)) {
            return $this->json(['message' => 'Aucun parent trouvé'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Retourner les séances sous format JSON
        return $this->json($seances, JsonResponse::HTTP_OK);
    }
}
