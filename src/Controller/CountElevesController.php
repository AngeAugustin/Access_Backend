<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Educateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class CountElevesController extends AbstractController
{
    #[Route('/api/count_eleves/{NPI_educateur}', name: 'api_count_eleves', methods: ['GET'])]
public function countEleves(string $NPI_educateur, EntityManagerInterface $entityManager): JsonResponse
{
    $query = $entityManager->createQuery(
        'SELECT COUNT(DISTINCT t.NPI_enfant) 
         FROM App\Entity\Tutorat t
         WHERE t.NPI_educateur = :NPI_educateur'
    )->setParameter('NPI_educateur', $NPI_educateur);

    $count = $query->getSingleScalarResult();

    return new JsonResponse([
        'NPI_educateur' => $NPI_educateur,
        'eleves_uniques' => (int) $count
    ]);
}

}
