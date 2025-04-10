<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Educateur; 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ProfilParentController extends AbstractController
{
    #[Route('/api/profil_parent/{NPI}', name: 'api_profil_parent', methods: ['GET'])]
    public function profilParent(string $NPI, EntityManagerInterface $entityManager): JsonResponse
    {
         // Récupérer l'utilisateur par NPI
         $user = $entityManager->getRepository(User::class)->findOneBy(['NPI' => $NPI]);

         if (!$user) {
             return new JsonResponse(['error' => 'Aucun utilisateur trouvé avec ce NPI'], Response::HTTP_NOT_FOUND);
         }

        $data = [
            'Telephone' => $user->getTelephone(),
            'Adresse' => $user->getAdresse(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

}
