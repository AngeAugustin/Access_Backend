<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Educateur;
use App\Entity\Tutorat;
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
         ->select('u.NPI', 'u.Name', 'u.Firstname', 'u.Email', 'u.Adresse', 'u.Matiere', 'd.Experience', 'd.Parcours', 't.NPI_enfant', 't.Duree_tutorat')
         ->leftJoin(Educateur::class, 'd', 'WITH', 'd.NPI = u.NPI')
         ->leftJoin(Tutorat::class, 't', 'WITH', 't.NPI_educateur = u.NPI')
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

     // Initialiser un tableau pour les données NPI_enfant et Duree_tutorat
     $tutoratDetails = [];

     // Extraire les données NPI_enfant et Duree_tutorat dans un tableau distinct
     foreach ($details as $detail) {
         if (isset($detail['NPI_enfant'], $detail['Duree_tutorat'])) {
             $tutoratDetails[] = [
                 'NPI_enfant' => $detail['NPI_enfant'],
                 'Duree_tutorat' => $detail['Duree_tutorat']
             ];
         }
     }

     // Retourner les données sous forme de JSON avec les deux ensembles
     return $this->json([
         'status' => JsonResponse::HTTP_OK,
         'data' => [
             'educateur' => array_values($educateurDetails), // Supprimer les doublons
             'tutorat' => $tutoratDetails // Tableau des données NPI_enfant et Duree_tutorat
         ]
     ], JsonResponse::HTTP_OK);
 }
}

