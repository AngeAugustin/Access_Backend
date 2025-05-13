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
    // Récupérer les éducateurs avec les infos basiques
    $educateursBase = $entityManager->getRepository(User::class)->createQueryBuilder('u')
        ->select('u.NPI, u.Name, u.Firstname, u.Matiere, u.Statut_profil, u.Adresse, e.Experience, e.Parcours, e.Etoiles')
        ->leftJoin('App\Entity\Educateur', 'e', 'WITH', 'e.NPI = u.NPI')
        ->where('u.Role = :role')
        ->andWhere('u.Statut_profil = :statutProfile')
        ->setParameter('role', 'EDUCATEUR')
        ->setParameter('statutProfile', 'Vérifié')
        ->getQuery()
        ->getArrayResult(); // ⚠️ Utilisation de getArrayResult pour tableau associatif

    // Ajouter la photo encodée en base64
    foreach ($educateursBase as &$educateurData) {
        $educateurEntity = $entityManager->getRepository(Educateur::class)->findOneBy([
            'NPI' => $educateurData['NPI']
        ]);

        $photoBase64 = null;
        if ($educateurEntity && $educateurEntity->getPhotoEducateur()) {
            $photoBase64 = base64_encode(stream_get_contents($educateurEntity->getPhotoEducateur()));
        }

        $educateurData['Photo_educateur'] = $photoBase64;
    }

    return new JsonResponse($educateursBase, JsonResponse::HTTP_OK);
}

}
 