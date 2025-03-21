<?php

namespace App\Controller;

use App\Entity\Educateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CompleteController extends AbstractController
{
    #[Route('/api/complete', name: 'api_complete', methods: ['POST'])]
    public function apiComplete(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = $request->request->all();
        $files = $request->files->all();

        if (empty($data)) { 
            return new JsonResponse(['error' => 'Données manquantes ou format incorrect'], Response::HTTP_BAD_REQUEST);
        }

        // Vérification que le NPI existe bien
        $educateur = $entityManager->getRepository(Educateur::class)->findOneBy(['NPI' => $data['NPI']]);
        if (!$educateur) {
            return new JsonResponse(['error' => 'Utilisateur introuvable'], Response::HTTP_NOT_FOUND);
        }

        // Mise à jour des informations
        $educateur->setExperience($data['Experience'] ?? null);
        $educateur->setParcours($data['Parcours'] ?? null);
        $educateur->setDateNaissance(new \DateTime($data['Date_naissance'] ?? 'now'));
        $educateur->setSituationMatrimoniale($data['Situation_matrimoniale'] ?? null);
        $educateur->setGarant1($data['Garant_1'] ?? null);
        $educateur->setAdresseGarant1($data['Adresse_garant1'] ?? null);
        $educateur->setGarant2($data['Garant_2'] ?? null);
        $educateur->setAdresseGarant2($data['Adresse_garant2'] ?? null);
        $educateur->setDispo1($data['Dispo1'] ?? null);
        $educateur->setDispo2($data['Dispo2'] ?? null);
        $educateur->setDispo3($data['Dispo3'] ?? null);
        $educateur->setDispo4($data['Dispo4'] ?? null);

        // Gestion des fichiers : Carte d'identité & Casier judiciaire
        if (isset($files['Carte_identite'])) {
            $carteIdentitePath = $this->uploadFile($files['Carte_identite'], 'carte_identite');
            $educateur->setCarteIdentite($carteIdentitePath);
        }

        if (isset($files['Casier_judiciaire'])) {
            $casierJudiciairePath = $this->uploadFile($files['Casier_judiciaire'], 'casier_judiciaire');
            $educateur->setCasierJudiciaire($casierJudiciairePath);
        }

        $entityManager->persist($educateur);
        $entityManager->flush();

        return new JsonResponse([
            'message' => 'Informations complétées avec succès',
            'NPI' => $educateur->getNPI()
        ]);
    }

    // Fonction utilitaire pour gérer les fichiers
    private function uploadFile(UploadedFile $file, string $folder): string
    {
        $uploadsDirectory = $this->getParameter('uploads_directory') . '/' . $folder;

        $fileName = uniqid() . '.' . $file->guessExtension();

        try {
            $file->move($uploadsDirectory, $fileName);
        } catch (FileException $e) {
            throw new \Exception("Erreur lors de l'upload du fichier: " . $e->getMessage());
        }

        return $folder . '/' . $fileName;
    }
}
