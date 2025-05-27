<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Educateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class GetEducBackendController extends AbstractController
{
    #[Route('/api/get_educ_backend', name: 'api_get_educ_backend', methods: ['GET'])]
    public function listeEducateursBackend(EntityManagerInterface $entityManager): JsonResponse
    {
        // Récupération des éducateurs avec une jointure sur la table Educateur
        $educateurs = $entityManager->getRepository(User::class)->createQueryBuilder('u')
            ->select('u.NPI, u.Name, u.Firstname, u.Matiere, u.Statut_profil, u.Adresse, e.Experience, e.Parcours, e.Etoiles')
            ->leftJoin('App\Entity\Educateur', 'e', 'WITH', 'e.NPI = u.NPI')
            ->where('u.Role = :role')
            ->setParameter('role', 'EDUCATEUR')
            ->getQuery()
            ->getResult();

        if (empty($educateurs)) {
            return $this->json([], JsonResponse::HTTP_OK);
        }

        // Ajout de la photo pour chaque éducateur
        foreach ($educateurs as &$educateur) {
            // Récupération de l'entité Educateur complète
            $educEntity = $entityManager->getRepository(Educateur::class)->findOneBy(['NPI' => $educateur['NPI']]);

            // Encodage de la photo s’il y en a une
            if ($educEntity && $educEntity->getPhotoEducateur()) {
                $educateur['Photo_educateur'] = base64_encode(stream_get_contents($educEntity->getPhotoEducateur()));
            } else {
                $educateur['Photo_educateur'] = null;
            }
        }

        return $this->json($educateurs, JsonResponse::HTTP_OK);
    }
}
