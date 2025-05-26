<?php

namespace App\Controller;

use App\Entity\Enfant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ListEnfantsController extends AbstractController
{
    #[Route('/api/list_enfants/{NPI}', name: 'app_list_enfants')]
    public function getEnfantsByNPI(string $NPI, EntityManagerInterface $entityManager): JsonResponse
    {
        $enfants = $entityManager->getRepository(Enfant::class)->findBy(['NPI' => $NPI]);

        if (!$enfants) {
            return new JsonResponse([
                'success' => false,
                'message' => 'Aucun enfant trouvé pour le parent avec ce NPI'
            ], Response::HTTP_NOT_FOUND);
        }

        $data = array_map(function ($enfant) {
            return [
                'NPI_enfant' => $enfant->getNPIEnfant(),
                'Nom_enfant' => $enfant->getNomEnfant(),
                'Prenom_enfant' => $enfant->getPrenomEnfant(),
                'Classe_actuelle' => $enfant->getClasseActuelle(),
            ];
        }, $enfants);

        return new JsonResponse([
            'success' => true,
            'data' => $data
        ], Response::HTTP_OK);
    }
}
