<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ProfilController extends AbstractController
{
    #[Route('/api/profil/{NPI}', name: 'api_profil', methods: ['GET'])]
    public function profil(string $NPI, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $entityManager->getRepository(User::class)->findOneBy(['NPI' => $NPI]);

        if (!$user) {
            return new JsonResponse(['error' => 'Aucun utilisateur trouvé avec ce NPI'], Response::HTTP_NOT_FOUND);
        }

        // Préparer les données de l'enfant
        $data = [
            'Telephone' => $user->getTelephone(),
            'Adresse' => $user->getAdresse(),
            'Statut_profil' => $user->getStatutProfil(),     
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
