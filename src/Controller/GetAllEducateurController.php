<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class GetAllEducateurController extends AbstractController
{
    #[Route('/api/get_all_educateurs', name: 'api_get_all_educateurs', methods: ['GET'])]
    public function listeEducateurs(EntityManagerInterface $entityManager): JsonResponse
    {
        // Récupération des éducateurs avec une validation de la requête
        $educateurs = $entityManager->getRepository(User::class)->createQueryBuilder('u')
            ->select('u.NPI, u.Name, u.Firstname, u.Matiere')
            ->where('u.Role = :role')
            ->setParameter('role', 'EDUCATEUR')
            ->getQuery()
            ->getResult();

        // Si aucun éducateur n'est trouvé
        if (empty($educateurs)) {
            return $this->json(['message' => 'Aucun éducateur trouvé'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Retourner les éducateurs sous format JSON
        return $this->json($educateurs, JsonResponse::HTTP_OK);
    }
}
