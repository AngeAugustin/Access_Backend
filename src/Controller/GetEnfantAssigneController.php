<?php

namespace App\Controller;

use App\Entity\Tutorat;
use App\Entity\Enfant;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class GetEnfantAssigneController extends AbstractController
{
    #[Route('/api/get_assignes', name: 'api_get_assignes', methods: ['GET'])]
    public function getAssignes(EntityManagerInterface $entityManager): JsonResponse
    {
        // Création de la requête pour récupérer tous les assignes
        $query = $entityManager->getRepository(Tutorat::class)->createQueryBuilder('t')
            ->select('t.Reference_tutorat, e.Nom_enfant, e.Prenom_enfant, u.Matiere')
            ->leftJoin(Enfant::class, 'e', 'WITH', 'e.NPI = t.NPI_enfant') 
            ->leftJoin(User::class, 'u', 'WITH', 'u.NPI = t.NPI_educateur') 
            ->getQuery();

        // Exécuter la requête pour récupérer tous les assignes
        $assignes = $query->getResult();

        // Vérifier si des tutorats ont été trouvés
        if (empty($assignes)) {
            return $this->json(['message' => 'Aucun tutorat trouvé'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Retourner les tutorats au format JSON
        return $this->json($assignes, JsonResponse::HTTP_OK);
    }
}
