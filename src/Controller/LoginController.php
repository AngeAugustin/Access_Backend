<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LoginController extends AbstractController
{
    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function apiLogin(Request $request, EntityManagerInterface $entityManager, SessionInterface $session): JsonResponse
    {
        // Récupération des données JSON envoyées
        $data = json_decode($request->getContent(), true);
        $Email = $data['Email'] ?? null;
        $Password = $data['Password'] ?? null;
        $Role = $data['Role'] ?? null;

        // Vérification si le nom d'utilisateur et le mot de passe sont fournis
        if (!$Email || !$Password || !$Role) {
            return new JsonResponse(['message' => 'Nom d\'utilisateur ou mot de passe manquant'], 400);
        }

        // Recherche de l'utilisateur dans la base de données
        $repository = $entityManager->getRepository(User::class);
        $user = $repository->findOneBy(['Email' => $Email]);

        if (!$user) {
            return new JsonResponse(['message' => 'Informations incorrectes'], 401);
        }

        // Vérification du mot de passe
        if (!$user->isValidPasswordUser($Password)) {
            return new JsonResponse(['message' => 'Mot de passe incorrect'], 401);
        }

        // Vérification du Role
        if (!$user->isValidRole($Role)) {
            return new JsonResponse(['message' => 'Vous ne disposez des droits nécessaires'], 401);
        }

        // Enregistrement des informations de l'utilisateur dans la session
        $session->set('Username', $user->getUsername());
        $session->set('Name', $user->getName());
        $session->set('Firstname', $user->getFirstname());
        $session->set('Email', $user->getEmail());
        $session->set('Role', $user->getRole());
        $session->set('NPI', $user->getNPI());
        $session->set('Telephone', $user->getTelephone());

        // Retour de la réponse de succès
        return new JsonResponse([
            'Message' => 'Connexion réussie',
            'Username' => $user->getUsername(),
            'Name' => $user->getName(),
            'Firstname' => $user->getFirstname(),
            'Email' => $user->getEmail(),
            'Role' => $user->getRole(),
            'NPI' => $user->getNPI()
        ]);
    }
}
