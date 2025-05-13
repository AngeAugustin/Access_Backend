<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Educateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class CountEducateursController extends AbstractController
{
    #[Route('/api/count_educateurs/{NPI_parent}', name: 'api_count_educateurs', methods: ['GET'])]
public function countEducateurs(string $NPI_parent, EntityManagerInterface $entityManager): JsonResponse
{
    $query = $entityManager->createQuery(
        'SELECT COUNT(DISTINCT t.NPI_educateur) 
         FROM App\Entity\Tutorat t 
         WHERE t.NPI_parent = :NPI_parent'
    )->setParameter('NPI_parent', $NPI_parent);

    $count = $query->getSingleScalarResult();

    return new JsonResponse([
        'NPI_parent' => $NPI_parent,
        'educateurs_uniques' => (int) $count
    ]);
}

}
