<?php

namespace App\Controller;

use App\Entity\Tutorat;
use App\Entity\Enfant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class GetDetailsElevesAssignesController extends AbstractController
{
    #[Route('/api/get_details_eleves_assignes/{NPI_enfant}', name: 'api_get_details_eleves_assignes', methods: ['GET'])]
    public function getDetailsElevesAssignes(string $NPI_enfant, EntityManagerInterface $entityManager): JsonResponse
    {
        // Création de la requête pour récupérer tous les détails de l'eleve assigne
        $query = $entityManager->getRepository(Tutorat::class)->createQueryBuilder('t')
            ->select('t.NPI_enfant', 't.Duree', 't.Observation_generale', 'e.Nom_enfant', 'e.Prenom_enfant', 'e.Classe_actuelle', 'Ecole_actuelle')
            ->leftJoin(Enfant::class, 'e', 'WITH', 'e.NPI_enfant = t.NPI_enfant')
            ->where('t.NPI_enfant = :NPI_enfant')
            ->setParameter('NPI_enfant', $NPI_enfant)
            ->getQuery();

        // Exécuter la requête pour récupérer tous les details
        $details = $query->getResult();

        // Vérifier si des détails ont été trouvés
        if (empty($details)) {
            return $this->json([
                'message' => 'Aucun détail trouvé pour cet élève ' . $NPI_enfant,
                'status' => JsonResponse::HTTP_NOT_FOUND
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        // Retourner les détails au format JSON
        return $this->json([
            'status' => JsonResponse::HTTP_OK,
            'data' => $details
        ], JsonResponse::HTTP_OK);
    }
}
