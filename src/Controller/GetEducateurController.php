<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Educateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GetEducateurController extends AbstractController
{
    #[Route('/api/get_educateur/{NPI}', name: 'api_get_educateur', methods: ['GET'])] 
    public function getEducateur(string $NPI, EntityManagerInterface $entityManager): JsonResponse
    {
        // Récupération de l'éducateur par son NPI
        $query = $entityManager->getRepository(User::class)->createQueryBuilder('u')
            ->select('u.NPI, u.Name, u.Firstname, u.Matiere, u.Email, u.Statut_profil, u.Adresse, e.Experience, e.Parcours, e.Etoiles, e.Photo_educateur') // Ajout de la photo
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

        // Vérifier si l'éducateur a une photo
        $photoEducateurPath = $educateur['Photo_educateur'] ?? null;
        if (!$photoEducateurPath) {
            return $this->json(['message' => 'Photo de l\'éducateur non trouvée'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Lire le fichier de l'image
        $path = $this->getParameter('uploads_directory') . '/' . $photoEducateurPath;
        if (!file_exists($path)) {
            return $this->json(['message' => 'Image non trouvée'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Créer un objet File à partir du fichier
        $file = new File($path);

        // Retourner l'image avec le type MIME approprié
        return new Response(
            file_get_contents($file->getRealPath()), // Le contenu du fichier
            Response::HTTP_OK, 
            [
                'Content-Type' => $file->getMimeType(), // Type MIME de l'image (par ex. image/jpeg)
                'Content-Disposition' => 'inline; filename="' . $file->getBasename() . '"', // Afficher l'image dans le navigateur
            ]
        );
    }
}
