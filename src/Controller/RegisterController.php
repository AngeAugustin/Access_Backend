<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{
    #[Route('/api/register', name: 'api_register', methods: ['POST'])]
    public function apiRegister(Request $request, EntityManagerInterface $entityManager): JsonResponse
    { 

        $data = json_decode($request->getContent(), true);
    
        if ($data === null) {
            return new JsonResponse(['error' => 'Invalid JSON format'], Response::HTTP_BAD_REQUEST);
        }
    
        // Existence d'un user avec le meme NPI
        $existingNPI = $entityManager->getRepository(User::class)->findOneBy(['NPI' => $data['NPI']]);
        if ($existingNPI) {
            return new JsonResponse(['error' => 'Un utilisateur avec le même NPI existe déjà'], Response::HTTP_BAD_REQUEST);
        }
        
        // Existence d'un user avec le meme telephone
        $existingTelephone = $entityManager->getRepository(User::class)->findOneBy(['Telephone' => $data['Telephone']]);
        if ($existingTelephone) {
            return new JsonResponse(['error' => 'Un utilisateur avec le même téléphone existe déjà'], Response::HTTP_BAD_REQUEST);
        }

        // Existence d'un user avec le meme email
        $existingEmail = $entityManager->getRepository(User::class)->findOneBy(['Email' => $data['Email']]);
        if ($existingEmail) {
            return new JsonResponse(['error' => 'Un utilisateur avec le même email existe déjà'], Response::HTTP_BAD_REQUEST);
        }

        // Enregistrement dans User
        $user = new User();
        $user->setNPI($data['NPI']);
        $user->setUsername($data['Username']);
        $user->setName($data['Name']);
        $user->setFirstname($data['Firstname']);
        $user->setEmail($data['Email']);
        $user->setTelephone($data['Telephone']);
        $user->setPassword($data['Password']);
        $user->setRole($data['Role']);

        $entityManager->persist($user);
        $entityManager->flush();
    
        return new JsonResponse(['Message' => 'Inscription réussie', 'Username' => $user->getUsername()]);
    }
    
}
