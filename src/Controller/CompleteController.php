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

    $educateur = $entityManager->getRepository(Educateur::class)->findOneBy(['NPI' => $data['NPI']]);
    if (!$educateur) {
        return new JsonResponse(['error' => 'Utilisateur introuvable'], Response::HTTP_NOT_FOUND);
    }

    // Mise à jour des informations de l'éducateur
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

    // Stockage des fichiers en BLOB
    if (isset($files['Carte_identite'])) {
        $educateur->setCarteIdentite(file_get_contents($files['Carte_identite']->getPathname()));
    }

    if (isset($files['Casier_judiciaire'])) {
        $educateur->setCasierJudiciaire(file_get_contents($files['Casier_judiciaire']->getPathname()));
    }

    if (isset($files['Photo_educateur'])) {
        $educateur->setPhotoEducateur(file_get_contents($files['Photo_educateur']->getPathname()));
    }

    $entityManager->persist($educateur);
    $entityManager->flush();

    return new JsonResponse([
        'message' => 'Informations complétées avec succès',
        'NPI' => $educateur->getNPI()
    ]);
}

}
