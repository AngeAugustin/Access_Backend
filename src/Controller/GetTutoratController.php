<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Tutorat;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
 
final class GetTutoratController extends AbstractController
{
    #[Route('/api/get_tutorat', name: 'api_get_tutorat', methods: ['GET'])]
    public function listTutorat(EntityManagerInterface $entityManager): JsonResponse
    {
        // Récupération des tutorats avec jointure sur la table User
        $tutorats = $entityManager->getRepository(Tutorat::class)
            ->createQueryBuilder('t')
            ->select('t.NPI_educateur, u.Name, u.Firstname, u.Matiere')
            ->leftJoin(User::class, 'u', 'WITH', 'u.NPI = t.NPI_educateur')
            ->getQuery()
            ->getResult();

        // Vérification et retour de la réponse JSON
        if (empty($tutorats)) {
            return $this->json([], JsonResponse::HTTP_OK);
        }

        return $this->json($tutorats, JsonResponse::HTTP_OK);
    }
}
