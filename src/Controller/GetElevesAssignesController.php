<?php

namespace App\Controller;

use App\Entity\Tutorat;
use App\Entity\Enfant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class GetElevesAssignesController extends AbstractController
{
    #[Route('/api/get_eleves_assignes/{NPI_educateur}', name: 'api_get_eleves_assignes', methods: ['GET'])]
    public function getElevesAssignes(string $NPI_educateur, EntityManagerInterface $entityManager): JsonResponse
    {
        // Création de la requête pour récupérer tous les eleves assignes
        $query = $entityManager->getRepository(Tutorat::class)->createQueryBuilder('t')
            ->select('t.NPI_enfant', 'e.Nom_enfant', 'e.Prenom_enfant', 'e.Classe_actuelle')
            ->leftJoin(Enfant::class, 'e', 'WITH', 'e.NPI_enfant = t.NPI_enfant')
            ->where('t.NPI_educateur = :NPI_educateur')
            ->setParameter('NPI_educateur', $NPI_educateur)
            ->getQuery();

        // Exécuter la requête pour récupérer tous les élèves assignes
        $assignes = $query->getResult();

        // Vérifier si des élèves assignés ont été trouvés
        if (empty($assignes)) {
            return $this->json([
                'message' => 'Aucun élève trouvé pour cet éducateur ' . $NPI_educateur,
                'status' => JsonResponse::HTTP_NOT_FOUND
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        // Retourner les élèves assignés au format JSON
        return $this->json([
            'status' => JsonResponse::HTTP_OK,
            'data' => $assignes
        ], JsonResponse::HTTP_OK);
    }
}