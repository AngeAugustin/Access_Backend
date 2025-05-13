<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Educateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class CountEnfantsController extends AbstractController
{
    #[Route('/api/count_enfants/{NPI}', name: 'api_count_enfants', methods: ['GET'])]
public function countEnfants(string $NPI, EntityManagerInterface $entityManager): JsonResponse
{
    $query = $entityManager->createQuery(
        'SELECT COUNT(DISTINCT e.NPI_enfant) 
         FROM App\Entity\Enfant e 
         WHERE e.NPI = :NPI'
    )->setParameter('NPI', $NPI);

    $count = $query->getSingleScalarResult();

    return new JsonResponse([
        'NPI_parent' => $NPI,
        'enfants_uniques' => (int) $count
    ]);
}

}
