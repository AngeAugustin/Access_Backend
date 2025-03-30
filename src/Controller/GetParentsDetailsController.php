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
        // Récupérer les informations du parent
        $parent = $entityManager->getRepository(User::class)->findOneBy(['NPI' => $NPI]);
        
        if (!$parent) {
            return $this->json([
                'message' => 'Aucun détail trouvé pour le parent avec NPI ' . $NPI,
                'status' => JsonResponse::HTTP_NOT_FOUND
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        // Récupérer les enfants du parent
        $enfants = $entityManager->getRepository(Enfant::class)->findBy(['NPI' => $NPI]);
        $enfantsData = array_map(function (Enfant $enfant) {
            return [
                'Nom_enfant' => $enfant->getNomEnfant(),
                'Prenom_enfant' => $enfant->getPrenomEnfant(),
                'Classe_actuelle' => $enfant->getClasseActuelle(),
            ];
        }, $enfants);

        // Récupérer les éducateurs associés au parent
        $tutorats = $entityManager->getRepository(Tutorat::class)->findBy(['NPI_parent' => $NPI]);
        $educateursNPIs = array_unique(array_map(function (Tutorat $tutorat) {
            return $tutorat->getNpiEducateur();
        }, $tutorats));

        // Récupérer les informations des éducateurs
        $educateurs = $entityManager->getRepository(User::class)->findBy(['NPI' => $educateursNPIs]);
        $educateursData = array_map(function (User $educateur) {
            return [
                'NPI_educateur' => $educateur->getNPI(),
                'Name' => $educateur->getName(),
                'Firstname' => $educateur->getFirstname(),
                'Matiere' => $educateur->getMatiere(),
            ];
        }, $educateurs);

        // Retourner les informations sous forme JSON
        return $this->json([
            'status' => JsonResponse::HTTP_OK,
            'data' => [
                'parent' => [
                    'NPI' => $parent->getNPI(),
                    'Name' => $parent->getName(),
                    'Firstname' => $parent->getFirstname(),
                    'Email' => $parent->getEmail(),
                    'Adresse' => $parent->getAdresse(),
                ],
                'enfants' => $enfantsData,
                'educateurs' => $educateursData
            ]
        ], JsonResponse::HTTP_OK);
    }
}
