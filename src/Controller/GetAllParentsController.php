<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class GetAllParentsController extends AbstractController
{
    #[Route('/api/get_all_parents', name: 'api_get_all_parents', methods: ['GET'])]
    public function listeParents(EntityManagerInterface $entityManager): JsonResponse
    {
        // Récupération des parents avec une validation de la requête
        $parents = $entityManager->getRepository(User::class)->createQueryBuilder('u')
            ->select('u.NPI, u.Name, u.Firstname, u.Nombre_enfants')
            ->where('u.Role = :role')
            ->setParameter('role', 'PARENT')
            ->getQuery()
            ->getResult();

        // Si aucun parent n'est trouvé
        if (empty($parents)) {
            return $this->json(['message' => 'Aucun parent trouvé'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Retourner les éducateurs sous format JSON
        return $this->json($parents, JsonResponse::HTTP_OK);
    }
}
