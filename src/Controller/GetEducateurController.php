<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Educateur;
use App\Entity\Tutorat;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class GetEducateurController extends AbstractController
{
    #[Route('/api/get_educateur/{NPI}', name: 'api_get_educateur', methods: ['GET'])]
    public function getEducateur(string $NPI, EntityManagerInterface $entityManager): JsonResponse
    {
        // Création de la requête pour récupérer les données nécessaires
        $query = $entityManager->getRepository(User::class)->createQueryBuilder('u')
            ->select('u.NPI', 'u.Name', 'u.Firstname', 'u.Email', 'u.Adresse', 'u.Matiere', 'd.Experience', 'd.Parcours', 't.NPI_enfant', 't.Duree_tutorat')
            ->leftJoin(Educateur::class, 'd', 'WITH', 'd.NPI = u.NPI')
            ->leftJoin(Tutorat::class, 't', 'WITH', 't.NPI_educateur = u.NPI')
            ->where('u.NPI = :NPI')
            ->setParameter('NPI', $NPI)
            ->getQuery();

        // Exécuter la requête pour récupérer les résultats
        $details = $query->getResult();

        // Vérifier si des détails ont été trouvés
        if (empty($details)) {
            return $this->json([
                'message' => 'Aucun détail trouvé pour éducateur avec NPI ' . $NPI,
                'status' => JsonResponse::HTTP_NOT_FOUND
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        // Initialisation des tableaux pour séparer les informations
        $infoEducateur = [];
        $infoTutorat = [];

        // Parcourir les résultats et séparer les données dans les tableaux respectifs
        foreach ($details as $detail) {
            // Information de l'éducateur (Parcours, Experience, Matiere)
            $infoEducateur[] = [
                'Parcours' => $detail['Parcours'],
                'Experience' => $detail['Experience'],
                'Matiere' => $detail['Matiere']
            ];

            // Information de tutora (NPI_enfant, Duree_tutorat)
            $infoTutorat[] = [
                'NPI_enfant' => $detail['NPI_enfant'],
                'Duree_tutorat' => $detail['Duree_tutorat']
            ];
        }

        // Retourner les détails séparés dans la réponse JSON
        return $this->json([
            'status' => JsonResponse::HTTP_OK,
            'data' => [
                'infoEducateur' => $infoEducateur,
                'infoTutorat' => $infoTutorat
            ]
        ], JsonResponse::HTTP_OK);
    }
}
