<?php

namespace App\Controller;


use App\Entity\Seance;
use App\Entity\Enfant;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class DetailsSeanceBackendController extends AbstractController
{
    #[Route('/api/details_seance_back/{id}', name: 'api_get_seance', methods: ['GET'])]
    public function getSeance(string $id, EntityManagerInterface $entityManager): JsonResponse
    {
        // Récupération de la séance avec jointures
        $seance = $entityManager->getRepository(Seance::class)
            ->createQueryBuilder('s')
            ->select(
                's.Id_seance',
                'e.Nom_enfant AS NomEnfant',
                'e.Prenom_enfant AS PrenomEnfant',
                'u.Name AS NomEducateur',
                'u.Firstname AS PrenomEducateur',
                'u.Matiere AS MatiereEducateur',
                's.Heure_seance',
                's.Observation',
                's.Travail_effectue',
                's.Date_seance'
            )
            ->leftJoin(Enfant::class, 'e', 'WITH', 's.NPI_enfant = e.NPI_enfant')
            ->leftJoin(User::class, 'u', 'WITH', 's.NPI_educateur = u.NPI')
            ->where('s.Id_seance = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();

        // Vérification si la séance existe
        if (!$seance) {
            return $this->json(['message' => 'Séance non trouvée'], JsonResponse::HTTP_NOT_FOUND);
        }

        // Retourner la séance sous format JSON
        return $this->json($seance, JsonResponse::HTTP_OK);
    }
}
