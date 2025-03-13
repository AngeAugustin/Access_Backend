<?php

namespace App\Controller;

use App\Entity\Enfant;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetEnfantController extends AbstractController
{
    #[Route('/api/get_enfant/{NPI_enfant}', name: 'api_get_enfant', methods: ['GET'])]
    public function getEnfant(string $NPI_enfant, EntityManagerInterface $entityManager): JsonResponse
    {
        $enfant = $entityManager->getRepository(Enfant::class)->findOneBy(['NPI_enfant' => $NPI_enfant]);

        if (!$enfant) {
            return new JsonResponse(['error' => 'Aucun enfant trouvé avec ce NPI_enfant'], Response::HTTP_NOT_FOUND);
        }

        // Préparer les données de l'enfant
        $data = [
            'NPI' => $enfant->getNPI(),
            'NPI_enfant' => $enfant->getNPIEnfant(),
            'Nom_enfant' => $enfant->getNomEnfant(),
            'Prenom_enfant' => $enfant->getPrenomEnfant(),
            'Date_naissance' => $enfant->getDateNaissance()->format('Y-m-d'),
            'Sexe_enfant' => $enfant->getSexeEnfant(),
            'Ecole_precedente' => $enfant->getEcolePrecedente(),
            'Classe_precedente' => $enfant->getClassePrecedente(),
            'Ecole_actuelle' => $enfant->getEcoleActuelle(),
            'Classe_actuelle' => $enfant->getClasseActuelle(),
            'Parent_tuteur' => $enfant->getParentTuteur(),
            'Matieres_preferes' => $enfant->getMatieresPreferes(),
            'Centre_interet' => $enfant->getCentreInteret(),
            'Niveau_francais' => $enfant->getNiveauFrancais(),
            'Niveau_anglais' => $enfant->getNiveauAnglais(),
            'Niveau_allemand' => $enfant->getNiveauAllemand(),
            'Niveau_espagnol' => $enfant->getNiveauEspagnol(),
            'Niveau_histgeo' => $enfant->getNiveauHistgeo(),
            'Niveau_mathematique' => $enfant->getNiveauMathematique(),
            'Niveau_pct' => $enfant->getNiveauPct(),
            'Niveau_philosophie' => $enfant->getNiveauPhilosophie(),
            'Niveau_svt' => $enfant->getNiveauSvt(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }
}
