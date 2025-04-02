<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Educateur;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
final class GetInfoEducParentsController extends AbstractController
{
    #[Route('/api/get_info_educ/{NPI}', name: 'app_get_info_educ_parents', methods: ['GET'])]
    public function getInfoEduc(string $NPI, EntityManagerInterface $entityManager): JsonResponse
    {
        // Création
        $query = $entityManager->getRepository(User::class)->createQueryBuilder('u')
            ->select('u.NPI', 'u.Name', 'u.Firstname', 'u.Matiere', 'e.Etoiles', 'e.Experience', 'e.Parcours')
            ->leftJoin(Educateur::class, 'e', 'WITH', 'e.NPI = u.NPI')
            ->where('u.NPI = :NPI')
            ->setParameter('NPI', $NPI)
            ->getQuery();

        // Exécuter la requête 
        $infos = $query->getResult();

        // Vérifier 
        if (empty($infos)) {
            return $this->json([
                'message' => 'Aucun INFOS trouvé t ' . $NPI,
                'status' => JsonResponse::HTTP_NOT_FOUND
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        // Retourner 
        return $this->json([
            'status' => JsonResponse::HTTP_OK,
            'data' => $infos
        ], JsonResponse::HTTP_OK);
    }
}
