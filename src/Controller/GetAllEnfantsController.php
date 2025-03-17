<?php

namespace App\Controller;

use App\Entity\Enfant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class GetAllEnfantsController extends AbstractController
{
    #[Route('/api/get_all_enfants', name: 'api_get_all_enfants',  methods: ['GET'])]
    public function listeEnfants(EntityManagerInterface $entityManager): JsonResponse
    {
        $enfants = $entityManager->getRepository(Enfant::class)->createQueryBuilder('e')
            ->select('e.NPI_enfant, e.Nom_enfant, e.Prenom_enfant, e.Classe_actuelle, e.Sexe_enfant')
            ->getQuery()
            ->getResult();

        return $this->json($enfants);
    }
}
