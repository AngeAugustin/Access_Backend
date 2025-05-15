<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ChangePasswordController extends AbstractController
{
    #[Route('/api/change-password', name: 'api_change_password', methods: ['POST'])]
    public function changePassword(
        Request $request,
        EntityManagerInterface $em
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $NPI = $data['NPI'] ?? null;
        $Password = $data['Password'] ?? null;

        if (!$NPI || !$Password) {
            return $this->json(['error' => 'NPI et mot de passe sont requis.'], 400);
        }

        $user = $em->getRepository(User::class)->findOneBy(['NPI' => $NPI]);

        if (!$user) {
            return $this->json(['error' => 'Utilisateur introuvable.'], 404);
        }

        $user->setPassword($Password); // Stockage en clair, comme demandé

        $em->persist($user);
        $em->flush();

        return $this->json(['message' => 'Mot de passe mis à jour avec succès.']);
    }
}
