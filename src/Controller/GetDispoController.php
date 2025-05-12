<?php

namespace App\Controller;

use App\Entity\Educateur;
use App\Entity\Tutorat;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class GetDispoController extends AbstractController
{
    #[Route('/api/get_dispo/{NPI}', name: 'api_get_dispo', methods: ['GET'])]
    public function getDispo(string $NPI, EntityManagerInterface $entityManager): JsonResponse
    {
        // Récupération de l'éducateur avec ses disponibilités
        $educateur = $entityManager->getRepository(Educateur::class)->findOneBy(['NPI' => $NPI]);

        if (!$educateur) {
            return new JsonResponse(['error' => 'Aucun éducateur trouvé avec ce NPI'], Response::HTTP_NOT_FOUND);
        }

        // Récupération des séances de tutorat associées à cet éducateur
        $tutorats = $entityManager->getRepository(Tutorat::class)->findBy(['NPI_educateur' => $NPI]);

        // Récupération de toutes les disponibilités de l'éducateur
        $disponibilites = [
            'Dispo1' => $educateur->getDispo1(),
            'Dispo2' => $educateur->getDispo2(),
            'Dispo3' => $educateur->getDispo3(),
            'Dispo4' => $educateur->getDispo4(),
        ];

        // Création d'un tableau pour stocker les séances programmées
        $seancesProgrammees = [];
        
        // Ajout des séances de tutorat au tableau des séances programmées
        foreach ($tutorats as $tutorat) {
            if ($tutorat->getSeance1()) {
                $seancesProgrammees[] = $tutorat->getSeance1();
            }
            if ($tutorat->getSeance2()) {
                $seancesProgrammees[] = $tutorat->getSeance2();
            }
        }

        // Filtrage des disponibilités pour ne garder que celles qui ne sont pas des séances programmées
        $disponibilitesLibres = [];
        foreach ($disponibilites as $key => $dispo) {
            if (!in_array($dispo, $seancesProgrammees) && $dispo !== null) {
                $disponibilitesLibres[$key] = $dispo;
            }
        }

        // Préparation des données pour la réponse
        $data = [
            'NPI' => $educateur->getNPI(),
            'disponibilites_libres' => $disponibilitesLibres
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }
}