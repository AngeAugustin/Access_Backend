<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


final class GetProfilDetailsController extends AbstractController
{
    #[Route('/api/get_profil_details/{NPI}', name: 'api_get_profil_details', methods: ['GET'])]
    public function getProfilDetails(string $NPI, EntityManagerInterface $entityManager): JsonResponse
    {
        $profil = $entityManager->getRepository(User::class)->findOneBy(['NPI' => $NPI]);

        if (!$profil) {
            return new JsonResponse(['error' => 'Aucun profil trouvé avec ce NPI'], Response::HTTP_NOT_FOUND);
        }

        // Préparer les données 
        $data = [ 
            'NPI' => $profil->getNPI(),
            'Name' => $profil->getName(),
            'Firstname' => $profil->getFirstname(),
            'Email' => $profil->getEmail(),
            'Adresse' => $profil->getAdresse(),
            'Telephone' => $profil->getTelephone(),
            'Situation_matrimoniale' => $profil->getSituationMatrimoniale(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
 