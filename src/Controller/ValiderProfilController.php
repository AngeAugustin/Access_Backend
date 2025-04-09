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
        // Trouver l'utilisateur par son NPI
        $user = $entityManager->getRepository(User::class)->findOneBy(['NPI' => $NPI]);

        if (!$user) {
            return new JsonResponse(['error' => 'Utilisateur non trouvé'], Response::HTTP_NOT_FOUND);
        }

        // Récupérer les données JSON de la requête
        $data = json_decode($request->getContent(), true);

        if (!isset($data['etoiles'], $data['niveau'])) {
            return new JsonResponse(['error' => 'Champs etoiles et niveau requis'], Response::HTTP_BAD_REQUEST);
        }

        // Mise à jour du statut du profil
        $user->setStatutProfil('Vérifié');

        // Accès à l'entité Educateur liée
        $educateur = $user->getEducateur();

        if (!$educateur instanceof Educateur) {
            return new JsonResponse(['error' => 'Educateur non associé à cet utilisateur'], Response::HTTP_NOT_FOUND);
        }

        // Mise à jour des attributs de l’éducateur
        $educateur->setEtoiles($data['etoiles']);
        $educateur->setNiveau($data['niveau']);

        $entityManager->persist($educateur);
        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Profil validé et informations mises à jour'], Response::HTTP_OK);
    }
}
