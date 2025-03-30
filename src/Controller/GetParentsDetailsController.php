<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Enfant;
use App\Entity\Tutorat;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GetParentsDetailsController extends AbstractController
{
    #[Route('/api/get_parents_details/{NPI}', name: 'api_get_parents_details', methods: ['GET'])]
    public function getParentsDetails(string $NPI, EntityManagerInterface $entityManager): JsonResponse
    {
        // Récupérer les informations du parent et des enfants
        $query = $entityManager->getRepository(User::class)->createQueryBuilder('u')
            ->select('u.NPI', 'u.Name', 'u.Firstname', 'u.Email', 'u.Adresse', 'e.Nom_enfant', 'e.Prenom_enfant', 'e.Classe_actuelle')
            ->leftJoin(Enfant::class, 'e', 'WITH', 'e.NPI = u.NPI')
            ->where('u.NPI = :NPI')
            ->setParameter('NPI', $NPI)
            ->getQuery();

        $parentEnfantDetails = $query->getResult();

        // Récupérer les NPI des éducateurs liés au parent
        $queryEducateurs = $entityManager->getRepository(Tutorat::class)->createQueryBuilder('t')
            ->select('t.NPI_educateur')
            ->where('t.NPI_parent = :NPI')
            ->setParameter('NPI', $NPI)
            ->getQuery();

        $npiEducateurs = $queryEducateurs->getResult();

        // Vérifier si des détails ont été trouvés
        if (empty($parentEnfantDetails)) {
            return $this->json([
                'message' => 'Aucun détail trouvé pour le parent avec NPI ' . $NPI,
                'status' => JsonResponse::HTTP_NOT_FOUND
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        // Retourner les détails au format JSON
        return $this->json([
            'status' => JsonResponse::HTTP_OK,
            'data' => [
                'parent_enfant' => $parentEnfantDetails,
                'npi_educateurs' => array_column($npiEducateurs, 'NPI_educateur') // Récupération sous forme de liste simple
            ]
        ], JsonResponse::HTTP_OK);
    }
}
