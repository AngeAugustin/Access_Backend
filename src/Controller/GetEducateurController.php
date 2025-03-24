<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Educateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class GetEducateurController extends AbstractController
{
    #[Route('/api/get_educateur/{NPI}', name: 'api_get_educateur', methods: ['GET'])]
    public function getEducateur(string $NPI, EntityManagerInterface $entityManager): JsonResponse
    {
        // Récupération de l'éducateur par son NPI
        $query = $entityManager->getRepository(User::class)->createQueryBuilder('u')
            ->select('u.NPI, u.Name, u.Firstname, u.Matiere, u.Email, u.Statut_profil, u.Adresse, e.Experience, e.Parcours, e.Etoiles')
            ->leftJoin(Educateur::class, 'e', 'WITH', 'e.NPI = u.NPI')
            ->where('u.Role = :role')
            ->andWhere('u.NPI = :NPI')
            ->setParameter('role', 'EDUCATEUR')
            ->setParameter('NPI', $NPI)
            ->getQuery();

        $educateur = $query->getOneOrNullResult();

        // Vérifier si un éducateur a été trouvé
        if (!$educateur) {
            return $this->json(['message' => 'Éducateur non trouvé'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Retourner les données au format JSON
        return $this->json($educateur, JsonResponse::HTTP_OK);
    }
}
