<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Educateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class GetAllEducateurController extends AbstractController
{
    #[Route('/api/get_all_educateurs', name: 'api_get_all_educateurs', methods: ['GET'])]
    public function listeEducateurs(EntityManagerInterface $entityManager): JsonResponse
    {
        // Récupération des éducateurs avec une jointure sur la table Etudiant
        $educateurs = $entityManager->getRepository(User::class)->createQueryBuilder('u')
            ->select('u.NPI, u.Name, u.Firstname, u.Matiere, u.Statut_profil, u.Adresse, e.Experience, e.Parcours, e.Etoiles')
            ->leftJoin('App\Entity\Educateur', 'e', 'WITH', 'e.NPI = u.NPI')
            ->where('u.Role = :role')
            ->setParameter('role', 'EDUCATEUR')
            ->getQuery()
            ->getResult();

        // Si aucun éducateur n'est trouvé
        if (empty($educateurs)) {
            return $this->json([], JsonResponse::HTTP_OK); // Retourne un tableau vide au lieu d'un message
        }
        

        // Retourner les éducateurs sous format JSON
        return $this->json($educateurs, JsonResponse::HTTP_OK);
    }
}
