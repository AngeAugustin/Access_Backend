<?php

namespace App\Controller;

use App\Entity\Reclamation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AddReclamationController extends AbstractController
{
    #[Route('/api/add_reclamation', name: 'add_reclamation', methods: ['POST'])]
    public function add(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

         if ($data === null) {
            return new JsonResponse(['error' => 'Invalid JSON format'], Response::HTTP_BAD_REQUEST);
        }

        $reclamation = new Reclamation();
        $reclamation->setIdReclamation($data['Id_reclamation']); 
        $reclamation->setNPIDemandant($data['NPI_demandant']);
        $reclamation->setMotif($data['Motif']);
        $reclamation->setDetails($data['Details']);
        $reclamation->setStatut('Nouveau');
        $reclamation->setMailDemandant($data['Mail_demandant']);
        $reclamation->setNomDemandant($data['Nom_demandant']);
        $reclamation->setPrenomDemandant($data['Prenom_demandant']);
        $reclamation->setRoleDemandant($data['Role_demandant']);

        $em->persist($reclamation);
        $em->flush();

        return new JsonResponse(['message' => 'Réclamation créée avec succès', 'id' => $data['Id_reclamation']], 201);
    }
}
