<?php

namespace App\Controller;

use App\Entity\Reclamation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class GetReclamationsController extends AbstractController
{
    #[Route('/api/get_all_reclamations', name: 'api_get_all_reclamations', methods: ['GET'])]
    public function listeReclamations(EntityManagerInterface $entityManager): JsonResponse
    {
        // Récupération des réclamations
        $reclamations = $entityManager->getRepository(Reclamation::class)
            ->createQueryBuilder('r')
            ->select('r.Id_reclamation, r.Date_demande, r.Nom_demandant, r.Prenom_demandant')
            ->getQuery()
            ->getResult();

        // Si aucune réclamation n'est trouvée
        if (empty($reclamations)) {
            return $this->json(['message' => 'Aucune réclamation trouvée'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Retour des données formatées
        return $this->json($reclamations, JsonResponse::HTTP_OK);
    }
}
