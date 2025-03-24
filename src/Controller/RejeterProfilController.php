<?php

namespace App\Controller;

use App\Entity\User; 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class RejeterProfilController extends AbstractController
{
    #[Route('/api/rejeter/{NPI}', name: 'api_rejeter', methods: ['PUT'])]
    public function rejet(string $NPI, EntityManagerInterface $entityManager): JsonResponse
    {
        // Trouver l'utilisateur par son NPI
        $user = $entityManager->getRepository(User::class)->findOneBy(['NPI' => $NPI]);

        // Vérifier si l'utilisateur existe
        if (!$user) {
            return new JsonResponse(['error' => 'Utilisateur non trouvé'], Response::HTTP_NOT_FOUND);
        }

        $user->setStatutProfil('Rejeté');

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Statut du profil rejeté avec succès'], Response::HTTP_OK);
    }
}
