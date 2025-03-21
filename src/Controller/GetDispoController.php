<?php

namespace App\Controller;

use App\Entity\Educateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GetDispoController extends AbstractController
{
    #[Route('/api/get_dispo/{NPI}', name: 'api_get_dispo', methods: ['GET'])]
    public function getDispo(string $NPI, EntityManagerInterface $entityManager): JsonResponse
    {
        $dispo = $entityManager->getRepository(Educateur::class)->findOneBy(['NPI' => $NPI]);

        if (!$dispo) {
            return new JsonResponse(['error' => 'Aucun disponibilité récupérée avec ce NPI'], Response::HTTP_NOT_FOUND);
        }

        $data = [ 
            'NPI' => $dispo->getNPI(),
            'Dispo1' => $dispo->getDispo1(),
            'Dispo2' => $dispo->getDispo2(),
            'Dispo3' => $dispo->getDispo3(),
            'Disp41' => $dispo->getDispo4(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
