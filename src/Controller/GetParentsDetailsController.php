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
        // 1️⃣ Récupérer l'utilisateur par son NPI
        $userRepo = $entityManager->getRepository(User::class);
        $user = $userRepo->findOneBy(['NPI' => $NPI]);

        if (!$user) {
            return new JsonResponse(['Error' => 'Utilisateur non trouvé'], 404);
        }

        // 2️⃣ Récupérer les informations de l'utilisateur
        $responseData = [
            'Name'     => $user->getName(),
            'Firstname' => $user->getFirstname(),
            'NPI'      => $user->getNpi(),
            'Email'    => $user->getEmail(),
            'Adresse'  => $user->getAdresse(),
            'Enfants'  => [],
            'Educateurs' => []
        ];

        // 3️⃣ Récupérer les enfants liés à cet utilisateur
        $enfantRepo = $entityManager->getRepository(Enfant::class);
        $enfants = $enfantRepo->findBy(['NPI' => $NPI]);

        foreach ($enfants as $enfant) {
            $responseData['Enfants'][] = [
                'Nom_enfant'     => $enfant->getNomEnfant(),
                'Prenom_enfant'  => $enfant->getPrenomEnfant(),
                'Classe_actuelle' => $enfant->getClasseActuelle(),
            ];
        }

        // 4️⃣ Récupérer les éducateurs liés via la table Tutorat
        $tutoratRepo = $entityManager->getRepository(Tutorat::class);
        $tutorats = $tutoratRepo->findBy(['NPI_Parent' => $NPI]);

        foreach ($tutorats as $tutorat) {
            $npiEducateur = $tutorat->getNpiEducateur();
            $educateur = $userRepo->findOneBy(['NPI' => $npiEducateur]);

            if ($educateur) {
                $responseData['Educateurs'][] = [
                    'Name'     => $educateur->getName(),
                    'Firstname' => $educateur->getFirstname(),
                    'Matiere'  => $educateur->getMatiere(),
                ];
            }
        }

        // 5️⃣ Retourner la réponse JSON unique
        return new JsonResponse($responseData);
    }
}
