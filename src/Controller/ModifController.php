<?php

namespace App\Controller;

use App\Entity\User; 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ModifController extends AbstractController
{
    #[Route('/api/modif/{NPI}', name: 'api_modif', methods: ['PUT'])]
    public function modif(string $NPI, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        // Récupérer les données JSON envoyées dans la requête
        $data = json_decode($request->getContent(), true);
    
        if ($data === null) {
            return new JsonResponse(['error' => 'Invalid JSON format'], Response::HTTP_BAD_REQUEST);
        }

        // Trouver l'utilisateur par son NPI
        $user = $entityManager->getRepository(User::class)->findOneBy(['NPI' => $NPI]);

        if (!$user) {
            return new JsonResponse(['error' => 'Utilisateur non trouvé'], Response::HTTP_NOT_FOUND);
        }

        // Vérifier et mettre à jour les champs 'telephone' et 'adresse'
        if (isset($data['Telephone'])) {
            $user->setTelephone($data['Telephone']);
        }

        if (isset($data['Adresse'])) {
            $user->setAdresse($data['Adresse']);
        }

        $entityManager->persist($user);
        $entityManager->flush();

        // Retourner une réponse JSON avec un message de succès
        return new JsonResponse(['message' => 'Utilisateur mise à jour avec succès'], Response::HTTP_OK);
    }
}
