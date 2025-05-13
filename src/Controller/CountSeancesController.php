<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Educateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class CountSeancesController extends AbstractController
{
    #[Route('/api/count_seances/{NPI_educateur}', name: 'api_count_seances', methods: ['GET'])]
public function countSeances(string $NPI_educateur, EntityManagerInterface $entityManager): JsonResponse
{
    $query = $entityManager->createQuery(
        'SELECT COUNT(DISTINCT s.Id_seance) 
         FROM App\Entity\Seance s 
         WHERE s.NPI_educateur = :NPI_educateur'
    )->setParameter('NPI_educateur', $NPI_educateur);

    $count = $query->getSingleScalarResult();

    return new JsonResponse([
        'NPI_educateur' => $NPI_educateur,
        'seances_uniques' => (int) $count
    ]);
}

}
