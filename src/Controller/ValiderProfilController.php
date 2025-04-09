<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Educateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ValiderProfilController extends AbstractController
{
    #[Route('/api/valider/{NPI}', name: 'api_valider', methods: ['PUT'])]
    public function valid(string $NPI, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        // Récupérer les données JSON
        $data = json_decode($request->getContent(), true);

        if (!isset($data['etoiles'], $data['niveau'])) {
            return new JsonResponse(['error' => 'Champs etoiles et niveau requis'], Response::HTTP_BAD_REQUEST);
        }

        // Trouver l'utilisateur
        $user = $entityManager->getRepository(User::class)->findOneBy(['NPI' => $NPI]);
        if (!$user) {
            return new JsonResponse(['error' => 'Utilisateur non trouvé'], Response::HTTP_NOT_FOUND);
        }

        // Trouver l'éducateur
        $educateur = $entityManager->getRepository(Educateur::class)->findOneBy(['NPI' => $NPI]);
        if (!$educateur) {
            return new JsonResponse(['error' => 'Éducateur non trouvé'], Response::HTTP_NOT_FOUND);
        }

        // Mise à jour
        $user->setStatutProfil('Vérifié');
        $educateur->setEtoiles($data['etoiles']);
        $educateur->setNiveau($data['niveau']);

        // Enregistrement
        $entityManager->persist($user);
        $entityManager->persist($educateur);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Profil validé et éducateur mis à jour'], Response::HTTP_OK);
    }
}
