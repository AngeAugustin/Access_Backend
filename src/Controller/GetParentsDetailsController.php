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
        // Création de la requête pour récupérer t
        $query = $entityManager->getRepository(User::class)->createQueryBuilder('u')
            ->select('u.NPI', 'u.Name', 'u.Firstname', 'u.Email', 'u.Adresse', 'e.Nom_enfant', 'e.Prenom_enfant', 'e.Classe_actuelle', 't.NPI_educateur')
            ->leftJoin(Enfant::class, 'e', 'WITH', 'e.NPI = u.NPI')
            ->leftJoin(Tutorat::class, 't', 'WITH', 't.NPI_parent = u.NPI')
            ->where('u.NPI = :NPI')
            ->setParameter('NPI', $NPI)
            ->getQuery();

        // Exécuter la requête pour récupérer 
        $details = $query->getResult();

        // Vérifier si des détails ont été trouvés
        if (empty($details)) {
            return $this->json([
                'message' => 'Aucun détail trouvé pour le parent avec NPI ' . $NPI,
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
