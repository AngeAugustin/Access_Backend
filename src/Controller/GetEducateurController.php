<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Educateur;
use App\Entity\Tutorat;
use App\Entity\Enfant; 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class GetEducateurController extends AbstractController
{
    #[Route('/api/get_educateur/{NPI}', name: 'api_get_educateur', methods: ['GET'])]
    public function getEducateur(string $NPI, EntityManagerInterface $entityManager): JsonResponse
    {
         // Création de la requête pour récupérer les données
         $query = $entityManager->getRepository(User::class)->createQueryBuilder('u')
         ->select('u.NPI', 'u.Name', 'u.Firstname', 'u.Email', 'u.Adresse', 'u.Matiere', 'd.Experience', 'd.Parcours', 
                  't.NPI_enfant', 't.Duree_tutorat', 'e.Nom_enfant', 'e.Prenom_enfant', 'e.Classe_actuelle')
         ->leftJoin(Educateur::class, 'd', 'WITH', 'd.NPI = u.NPI')
         ->leftJoin(Tutorat::class, 't', 'WITH', 't.NPI_educateur = u.NPI')
         ->leftJoin(Enfant::class, 'e', 'WITH', 'e.NPI_enfant = t.NPI_enfant') 
         ->where('u.NPI = :NPI')
         ->setParameter('NPI', $NPI)
         ->getQuery();

     // Exécuter la requête pour récupérer les résultats
     $details = $query->getResult();

     // Vérifier si des détails ont été trouvés
     if (empty($details)) {
         return $this->json([
             'message' => 'Aucun détail trouvé pour éducateur avec NPI ' . $NPI,
             'status' => JsonResponse::HTTP_NOT_FOUND
         ], JsonResponse::HTTP_NOT_FOUND);
     }

     // Créer un tableau associatif pour éviter les doublons dans les informations de l'éducateur
     $educateurDetails = [];
     foreach ($details as $detail) {
         $educateurDetails[$detail['NPI']] = [
             'NPI' => $detail['NPI'],
             'Name' => $detail['Name'],
             'Firstname' => $detail['Firstname'],
             'Email' => $detail['Email'],
             'Adresse' => $detail['Adresse'],
             'Matiere' => $detail['Matiere'],
             'Experience' => $detail['Experience'],
             'Parcours' => $detail['Parcours']
         ];
     }

     // Initialiser un tableau pour les données NPI_enfant, Nom_enfant, Prenom_enfant et Classe_actuelle
     $tutoratDetails = [];

     // Extraire les données NPI_enfant, Nom_enfant, Prenom_enfant, Classe_actuelle et Duree_tutorat
     foreach ($details as $detail) {
         if (isset($detail['Nom_enfant'], $detail['Prenom_enfant'], $detail['Classe_actuelle'], $detail['Duree_tutorat'])) {
             $tutoratDetails[] = [
                 'Nom_enfant' => $detail['Nom_enfant'],
                 'Prenom_enfant' => $detail['Prenom_enfant'],
                 'Classe_actuelle' => $detail['Classe_actuelle'],
                 'Duree_tutorat' => $detail['Duree_tutorat']
             ];
         }
     }

     // Retourner les données sous forme de JSON avec les deux ensembles
     return $this->json([
         'status' => JsonResponse::HTTP_OK,
         'data' => [
             'educateur' => array_values($educateurDetails), // Supprimer les doublons
             'tutorat' => $tutoratDetails // Tableau des données Nom_enfant, Prenom_enfant, Classe_actuelle et Duree_tutorat
         ]
     ], JsonResponse::HTTP_OK);
 }
}
