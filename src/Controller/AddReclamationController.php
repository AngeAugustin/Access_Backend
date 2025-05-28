<?php

namespace App\Controller;

use App\Entity\Reclamation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddReclamationController extends AbstractController
{
    #[Route('/api/add_reclamation', name: 'add_reclamation', methods: ['POST'])]
    public function add(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (
            !isset($data['NPI_demandant']) ||
            !isset($data['Motif']) ||
            !isset($data['Details']) ||
            !isset($data['Mail_demandant'])||
            !isset($data['Nom_demandant'])||
            !isset($data['Prenom_demandant'])||
            !isset($data['Role_demandant'])
        ) {
            return new JsonResponse(['error' => 'Données incomplètes'], 400);
        }

        // Génération ID aléatoire à 10 chiffres
        $id = random_int(1000000000, 9999999999);

        $reclamation = new Reclamation();
        $reclamation->setIdReclamation($id)
            ->setNPIDemandant($data['NPI_demandant'])
            ->setMotif($data['Motif'])
            ->setDetails($data['Details'])
            ->setStatut('Nouveau')
            ->setMailDemandant($data['Mail_demandant'])
            ->setNomDemandant($data['Nom_demandant'])
            ->setPrenomDemandant($data['Prenom_demandant'])
            ->setRoleDemandant($data['Role_demandant']);

        $em->persist($reclamation);
        $em->flush();

        return new JsonResponse(['message' => 'Réclamation créée avec succès', 'id' => $id], 201);
    }
}
