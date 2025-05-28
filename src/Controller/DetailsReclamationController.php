<?php

namespace App\Controller;

use App\Entity\Reclamation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class DetailsReclamationController extends AbstractController
{
    #[Route('/api/reclamation_details/{Id_reclamation}', name: 'api_reclamation_details', methods: ['GET'])]
    public function getReclamationDetails(string $Id_reclamation, EntityManagerInterface $entityManager): JsonResponse
    {
        // Requête pour récupérer la réclamation correspondant à l'Id_reclamation
        $reclamation = $entityManager->getRepository(Reclamation::class)
            ->createQueryBuilder('r')
            ->select('
                r.Id_reclamation,
                r.NPI_demandant,
                r.Nom_demandant,
                r.Prenom_demandant,
                r.Mail_demandant,
                r.Date_demande,
                r.Motif,
                r.Details,
                r.Statut
            ')
            ->where('r.Id_reclamation = :id')
            ->setParameter('id', $Id_reclamation)
            ->getQuery()
            ->getResult();

        // Aucune réclamation trouvée pour cet Id
        if (empty($reclamation)) {
            return $this->json(['message' => 'Aucune réclamation trouvée pour cet Id'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Retourner les données
        return $this->json($reclamation, JsonResponse::HTTP_OK);
    }
}
