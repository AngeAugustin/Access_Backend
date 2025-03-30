<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Educateur;
use App\Entity\Tutorat;
use App\Entity\Enfant;  // Ajoutez cette ligne pour importer la table Enfant
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class GetEducateurController extends AbstractController
{
    #[Route('/api/get_educateur/{NPI}', name: 'api_get_educateur', methods: ['GET'])]
    public function getEducateur(string $NPI, EntityManagerInterface $entityManager): JsonResponse
    {
        // Création de la requête pour récupérer les données nécessaires, y compris les informations de l'enfant
        $query = $entityManager->getRepository(User::class)->createQueryBuilder('u')
            ->select('u.NPI', 'u.Name', 'u.Firstname', 'u.Email', 'u.Adresse', 'd.Matiere', 'd.Experience', 'd.Parcours', 't.NPI_enfant', 't.Duree_tutorat', 'e.Nom_enfant', 'e.Prenom_enfant', 'e.Classe_actuelle')
            ->leftJoin(Educateur::class, 'd', 'WITH', 'd.NPI = u.NPI')
            ->leftJoin(Tutorat::class, 't', 'WITH', 't.NPI_educateur = u.NPI')
            ->leftJoin(Enfant::class, 'e', 'WITH', 'e.NPI_enfant = t.NPI_enfant') // Jointure avec la table Enfant
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

        // Initialisation des tableaux pour les informations
        $infoEducateur = [
            'NPI' => $details[0]['NPI'],
            'Name' => $details[0]['Name'],
            'Firstname' => $details[0]['Firstname'],
            'Email' => $details[0]['Email'],
            'Adresse' => $details[0]['Adresse'],
            'Matiere' => $details[0]['Matiere'],
            'Experience' => $details[0]['Experience'],
            'Parcours' => $details[0]['Parcours']
        ];

        // Initialisation du tableau pour les informations de tutorat
        $infoTutorat = [];

        // Parcourir les résultats et séparer les données dans les tableaux respectifs
        foreach ($details as $detail) {
            // Information de tutora (remplacer NPI_enfant par les infos de l'enfant)
            $infoTutorat[] = [
                'Nom_enfant' => $detail['Nom_enfant'],
                'Prenom_enfant' => $detail['Prenom_enfant'],
                'Classe_actuelle' => $detail['Classe_actuelle'],
                'Duree_tutorat' => $detail['Duree_tutorat']
            ];
        }

        // Retourner les détails dans la réponse JSON avec les informations de l'éducateur en premier
        return $this->json([
            'status' => JsonResponse::HTTP_OK,
            'data' => [
                'infoEducateur' => $infoEducateur,
                'infoTutorat' => $infoTutorat
            ]
        ], JsonResponse::HTTP_OK);
    }
}
