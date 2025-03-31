<?php

namespace App\Controller;

use App\Entity\Educateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GetFilesController extends AbstractController
{
    #[Route('/api/get-all-files/{npi}', name: 'api_get_all_files', methods: ['GET'])]
    public function getAllFiles(string $npi, EntityManagerInterface $entityManager): JsonResponse
    {
        $educateur = $entityManager->getRepository(Educateur::class)->findOneBy(['NPI' => $npi]);

        if (!$educateur) {
            return new JsonResponse(['error' => 'Utilisateur introuvable'], Response::HTTP_NOT_FOUND);
        }

        $files = [
            'Carte_identite' => $educateur->getCarteIdentite() ? base64_encode(stream_get_contents($educateur->getCarteIdentite())) : null,
            'Casier_judiciaire' => $educateur->getCasierJudiciaire() ? base64_encode(stream_get_contents($educateur->getCasierJudiciaire())) : null,
            'Photo_educateur' => $educateur->getPhotoEducateur() ? base64_encode(stream_get_contents($educateur->getPhotoEducateur())) : null,
        ];

        return new JsonResponse([
            'NPI' => $educateur->getNPI(),
            'files' => $files
        ]);
    }


}
