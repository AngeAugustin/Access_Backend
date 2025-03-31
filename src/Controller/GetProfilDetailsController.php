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
        $query = $entityManager->createQuery(
            'SELECT u.NPI, u.Name, u.Firstname, u.Email, u.Adresse, u.Telephone, 
                    u.Situation_matrimoniale, u.Statut_profil, 
                    e.Garant_1, e.Garant_2
            FROM App\Entity\User u
            LEFT JOIN App\Entity\Educateur e WITH u.NPI = e.NPI
            WHERE u.NPI = :NPI'
        )->setParameter('NPI', $NPI);

        $profil = $query->getOneOrNullResult();

        if (!$profil) {
            return new JsonResponse(['error' => 'Aucun profil trouvé avec ce NPI'], Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($profil, Response::HTTP_OK);
    }
}
