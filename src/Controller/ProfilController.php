<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Educateur; // Assure-toi d'importer l'entité Educateur
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ProfilController extends AbstractController
{
    #[Route('/api/profil/{NPI}', name: 'api_profil', methods: ['GET'])]
    public function profil(string $NPI, EntityManagerInterface $entityManager): JsonResponse
    {
        // Récupérer l'utilisateur par NPI
        $user = $entityManager->getRepository(User::class)->findOneBy(['NPI' => $NPI]);

        if (!$user) {
            return new JsonResponse(['error' => 'Aucun utilisateur trouvé avec ce NPI'], Response::HTTP_NOT_FOUND);
        }

        // Récupérer la matière
        $matiere = $user->getMatiere(); // La matière est un attribut directement accessible

        // Récupérer les informations de l'éducateur via une jointure
        $educateur = $entityManager->getRepository(Educateur::class)->findOneBy(['NPI' => $NPI]);

        if (!$educateur) {
            return new JsonResponse(['error' => 'Aucun éducateur trouvé avec ce NPI'], Response::HTTP_NOT_FOUND);
        }

        // Convertir la photo de l'éducateur en Base64 si elle existe
        $photoEducateurBase64 = null;
        if ($educateur->getPhotoEducateur()) {
            $photoEducateurBase64 = base64_encode(stream_get_contents($educateur->getPhotoEducateur()));
        }

        // Préparer les données à retourner
        $data = [
            'Telephone' => $user->getTelephone(),
            'Adresse' => $user->getAdresse(),
            'Statut_profil' => $user->getStatutProfil(),
            'Matiere' => $matiere, // La matière est simplement un attribut de User
            'Photo_educateur' => $photoEducateurBase64, // Photo convertie en Base64
            'Niveau' => $educateur->getNiveau(), // Ajouter le niveau de l'éducateur
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
