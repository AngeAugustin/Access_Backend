<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GetProfilDetailsController extends AbstractController
{
    #[Route('/api/get_profil_details/{NPI}', name: 'api_get_profil_details', methods: ['GET'])]
    public function getProfilDetails(string $NPI, EntityManagerInterface $entityManager): JsonResponse
    {
        $query = $entityManager->createQuery(
            'SELECT u.NPI, u.Name, u.Firstname, u.Email, u.Adresse, u.Telephone, 
                    e.Situation_matrimoniale, u.Statut_profil, 
                    e.Garant_1, e.Garant_2, 
                    e.Photo_educateur, e.Carte_identite, e.Casier_judiciaire
            FROM App\Entity\User u
            LEFT JOIN App\Entity\Educateur e WITH u.NPI = e.NPI
            WHERE u.NPI = :NPI'
        )->setParameter('NPI', $NPI);

        $profil = $query->getOneOrNullResult();

        if (!$profil) {
            return new JsonResponse(['error' => 'Aucun profil trouvé avec ce NPI'], Response::HTTP_NOT_FOUND);
        }

        // Convertir les fichiers Blob en Base64
        if ($profil['Photo_educateur']) {
            $profil['Photo_educateur'] = base64_encode(stream_get_contents($profil['Photo_educateur']));
        }
        if ($profil['Carte_identite']) {
            $profil['Carte_identite'] = base64_encode(stream_get_contents($profil['Carte_identite']));
        }
        if ($profil['Casier_judiciaire']) {
            $profil['Casier_judiciaire'] = base64_encode(stream_get_contents($profil['Casier_judiciaire']));
        }

        return new JsonResponse($profil, Response::HTTP_OK);
    }
}
