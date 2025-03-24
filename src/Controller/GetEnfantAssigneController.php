<?php

namespace App\Controller;

use App\Entity\Tutorat;
use App\Entity\Enfant;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class GetEnfantAssigneController extends AbstractController
{
    #[Route('/api/get_assignes/{NPI_parent}', name: 'api_get_assignes', methods: ['GET'])]
    public function getAssignes(string $NPI_parent, EntityManagerInterface $entityManager): JsonResponse
    {
        // Création de la requête pour récupérer tous les assignes
        $query = $entityManager->getRepository(Tutorat::class)->createQueryBuilder('t')
            ->select('t.Reference_tutorat', 't.NPI_parent', 'e.Nom_enfant', 'e.Prenom_enfant', 'u.Matiere')
            ->leftJoin(Enfant::class, 'e', 'WITH', 'e.NPI_enfant = t.NPI_enfant')
            ->leftJoin(User::class, 'u', 'WITH', 'u.NPI = t.NPI_educateur')
            ->where('t.NPI_parent = :NPI_parent')
            ->setParameter('NPI_parent', $NPI_parent)
            ->getQuery();

        // Exécuter la requête pour récupérer tous les assignes
        $assignes = $query->getResult();

        // Vérifier si des tutorats ont été trouvés
        if (empty($assignes)) {
            return $this->json([
                'message' => 'Aucun tutorat trouvé pour le parent avec NPI ' . $NPI_parent,
                'status' => JsonResponse::HTTP_NOT_FOUND
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        // Retourner les tutorats au format JSON
        return $this->json([
            'status' => JsonResponse::HTTP_OK,
            'data' => $assignes
        ], JsonResponse::HTTP_OK);
    }
}

