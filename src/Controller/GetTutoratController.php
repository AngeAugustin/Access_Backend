<?php

namespace App\Controller;


use App\Entity\Tutorat;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
 
final class GetTutoratController extends AbstractController
{
    #[Route('/api/get_tutorat/{NPI_parent}', name: 'api_get_tutorat', methods: ['GET'])]
    public function listTutorat(EntityManagerInterface $entityManager, Request $request, string $NPI_parent): JsonResponse
    {
        // Récupération des tutorats avec jointure sur la table User et filtre sur le NPI_parent
        $tutorats = $entityManager->getRepository(Tutorat::class)
            ->createQueryBuilder('t')
            ->select('DISTINCT t.NPI_educateur, u.Name, u.Firstname, u.Matiere')
            ->leftJoin(User::class, 'u', 'WITH', 'u.NPI = t.NPI_educateur')
            ->where('t.NPI_parent = :npiParent')
            ->setParameter('npiParent', $NPI_parent)
            ->getQuery()
            ->getResult();

        // Vérification et retour de la réponse JSON
        if (empty($tutorats)) {
            return $this->json([], JsonResponse::HTTP_OK);
        }

        return $this->json($tutorats, JsonResponse::HTTP_OK);
    }
}
