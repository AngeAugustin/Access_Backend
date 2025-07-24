<?php

namespace App\Controller;

use App\Entity\Educateur;
use App\Entity\User;
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

    // Récupérer l'utilisateur associé à l'éducateur et mettre à jour son statut
    $user = $educateur->getUser();
    if ($user) {
        $user->setStatutProfil('Soumis');
        $entityManager->persist($user);
    }

    // Mise à jour des jours et heures des disponibilités
    $educateur->setDispo1Jour($data['Dispo1_jour'] ?? null);
    $educateur->setDispo1Heure($data['Dispo1_heure'] ?? null);
    $educateur->setDispo2Jour($data['Dispo2_jour'] ?? null);
    $educateur->setDispo2Heure($data['Dispo2_heure'] ?? null);
    $educateur->setDispo3Jour($data['Dispo3_jour'] ?? null);
    $educateur->setDispo3Heure($data['Dispo3_heure'] ?? null);
    $educateur->setDispo4Jour($data['Dispo4_jour'] ?? null);
    $educateur->setDispo4Heure($data['Dispo4_heure'] ?? null);

    // Mise à jour automatique des anciens champs Dispo avec concaténation jour + heure
    $educateur->setDispo1($this->formatDisponibilite($data['Dispo1_jour'] ?? null, $data['Dispo1_heure'] ?? null));
    $educateur->setDispo2($this->formatDisponibilite($data['Dispo2_jour'] ?? null, $data['Dispo2_heure'] ?? null));
    $educateur->setDispo3($this->formatDisponibilite($data['Dispo3_jour'] ?? null, $data['Dispo3_heure'] ?? null));
    $educateur->setDispo4($this->formatDisponibilite($data['Dispo4_jour'] ?? null, $data['Dispo4_heure'] ?? null));

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

    if (isset($files['Diplome_academique'])) {
        $educateur->setDiplomeAcademique(file_get_contents($files['Diplome_academique']->getPathname()));
    }

    if (isset($files['Diplome_professionnel'])) {
        $educateur->setDiplomeProfessionnel(file_get_contents($files['Diplome_professionnel']->getPathname()));
    }

    $entityManager->persist($educateur);
    $entityManager->flush();

    return new JsonResponse([
        'message' => 'Informations complétées avec succès',
        'NPI' => $educateur->getNPI()
    ]);
}

/**
 * Formate une disponibilité en concaténant le jour et l'heure
 * 
 * @param string|null $jour Le jour de la semaine (ex: "Lundi")
 * @param string|null $heure L'intervalle horaire (ex: "08h-11h")
 * @return string|null La disponibilité formatée (ex: "Lundi 08h-11h") ou null si les deux paramètres sont vides
 */
private function formatDisponibilite(?string $jour, ?string $heure): ?string
{
    // Si les deux valeurs sont nulles ou vides, retourner null
    if (empty($jour) && empty($heure)) {
        return null;
    }
    
    // Si seulement le jour est renseigné
    if (!empty($jour) && empty($heure)) {
        return $jour;
    }
    
    // Si seulement l'heure est renseignée
    if (empty($jour) && !empty($heure)) {
        return $heure;
    }
    
    // Si les deux sont renseignés, les concaténer
    return $jour . ' ' . $heure;
}

}
