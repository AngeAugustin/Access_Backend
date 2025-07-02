<?php

namespace App\Controller;

use App\Entity\Seance;
use App\Entity\Tutorat; 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AddSeanceController extends AbstractController
{
    #[Route('/api/add_seance', name: 'api_add_seance', methods: ['POST'])]
public function apiAddSeance(Request $request, EntityManagerInterface $entityManager): JsonResponse
{  
    $data = json_decode($request->getContent(), true);

    if ($data === null) {
        return new JsonResponse(['error' => 'Invalid JSON format'], Response::HTTP_BAD_REQUEST);
    }

    // Vérification de l'existence de l'ID séance
    $existingID = $entityManager->getRepository(Seance::class)->findOneBy(['Id_seance' => $data['Id_seance']]);
    if ($existingID) {
        return new JsonResponse(['error' => 'Cette séance a déjà été validée.'], Response::HTTP_BAD_REQUEST);
    }

    // Requête avec jointure explicite
    $qb = $entityManager->createQueryBuilder();
    $qb->select('t')
       ->from('App\Entity\Tutorat', 't')
       ->where('t.Reference_tutorat = :ref')
       ->setParameter('ref', $data['Reference_tutorat']);

    $tutorat = $qb->getQuery()->getOneOrNullResult();

    if (!$tutorat) {
        return new JsonResponse(['error' => 'La référence de tutorat est invalide.'], Response::HTTP_BAD_REQUEST);
    }

    // Incrémentation de la durée réelle
    $tutorat->setDureeReel($tutorat->getDureeReel() + 1);

    // Création et enregistrement de la séance
    $seance = new Seance();
    $seance->setIdSeance($data['Id_seance']);
    $seance->setReferenceTutorat($data['Reference_tutorat']);
    $seance->setDateSeance(new \DateTime());
    $seance->setHeureSeance($data['Heure_seance']);
    $seance->setObservation($data['Observation']);
    $seance->setTravailEffectue($data['Travail_effectue']);
    $seance->setNPIEducateur($data['NPI_educateur']);
    $seance->setNPIEnfant($data['NPI_enfant']);

    $entityManager->persist($seance);
    $entityManager->persist($tutorat); // Important pour que la mise à jour soit prise en compte
    $entityManager->flush();

    return new JsonResponse([
        'Message' => 'Séance ajoutée avec succès',
        'Id_seance' => $seance->getIdSeance()
    ]);
}

}
