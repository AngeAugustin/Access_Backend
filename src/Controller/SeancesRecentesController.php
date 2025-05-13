<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class SeancesRecentesController extends AbstractController
{
    #[Route('/api/seances_recentes/{NPI_educateur}', name: 'api_educateur_seances_recents', methods: ['GET'])]
    public function getDernieresSeances(string $NPI_educateur, EntityManagerInterface $entityManager): JsonResponse
    {
        $query = $entityManager->createQuery(
            'SELECT s.Id_seance, s.Date_seance, s.Heure_seance, e.Nom_enfant, e.Prenom_enfant
             FROM App\Entity\Seance s
             JOIN App\Entity\Enfant e WITH s.NPI_enfant = e.NPI_enfant
             WHERE s.NPI_educateur = :npi
             ORDER BY s.Date_seance DESC, s.Heure_seance DESC'
        )
        ->setParameter('npi', $NPI_educateur)
        ->setMaxResults(3);

        $results = $query->getResult(); // objets avec DateTime pour la date

        // Formater la date avant d’envoyer le JSON
        $formatted = array_map(function ($row) {
            return [
                'Id_seance' => $row['Id_seance'],
                'Date_seance' => $row['Date_seance'] instanceof \DateTimeInterface
                    ? $row['Date_seance']->format('d-m-Y')
                    : null,
                'Heure_seance' => $row['Heure_seance'],
                'Nom_enfant' => $row['Nom_enfant'],
                'Prenom_enfant' => $row['Prenom_enfant'],
            ];
        }, $results);

        return new JsonResponse($formatted);
    }
}
