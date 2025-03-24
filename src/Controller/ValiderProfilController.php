<?php

namespace App\Controller;

use App\Entity\User; 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ValiderProfilController extends AbstractController
{
    #[Route('/api/valider/{NPI}', name: 'api_valider', methods: ['PUT'])]
    public function valid(string $NPI, EntityManagerInterface $entityManager): JsonResponse
    {
        // Trouver l'utilisateur par son NPI
        $user = $entityManager->getRepository(User::class)->findOneBy(['NPI' => $NPI]);

        // Vérifier si l'utilisateur existe
        if (!$user) {
            return new JsonResponse(['error' => 'Utilisateur non trouvé'], Response::HTTP_NOT_FOUND);
        }

        $user->setStatutProfil('Vérifié');

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Statut du profil mis à jour avec succès'], Response::HTTP_OK);
    }
}
