<?php

namespace App\Controller;

use App\Entity\Tutorat;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AddTutoratController extends AbstractController  
{
    #[Route('/api/add_tutorat', name: 'api_add_tutorat', methods: ['POST'])]
    public function apiAddTutorat(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {  

        $data = json_decode($request->getContent(), true);
    
        if ($data === null) {
            return new JsonResponse(['error' => 'Invalid JSON format'], Response::HTTP_BAD_REQUEST);
        }

        // Existence d'un tutorat avec la même référence
        $existingReference = $entityManager->getRepository(Tutorat::class)->findOneBy(['Reference_tutorat' => $data['Reference_tutorat']]);
        if ($existingReference) {
            return new JsonResponse(['error' => 'Une relation de tutorat avec la même référence existe déjà'], Response::HTTP_BAD_REQUEST);
        }

        // Enregistrement dans Tutorat
        $tutorat = new Tutorat();
        $tutorat->setReferenceTutorat($data['Reference_tutorat']);
        $tutorat->setNPIParent($data['NPI_parent']);
        $tutorat->setNPIEducateur($data['NPI_educateur']);
        $tutorat->setNPIParent($data['NPI_parent']);
        $tutorat->setDureeTutorat($data['Duree_tutorat']);
        $tutorat->setSeance1($data['Seance1']);
        $tutorat->setSeance2($data['Seance2']);
        $tutorat->setStatutTutorat('En cours');
        $tutorat->setDateTutorat(new \DateTime());

        $entityManager->persist($tutorat);
        $entityManager->flush();
    
        return new JsonResponse(['Message' => 'Relation de tutorat créé avec succès', 'Reference_tutorat' => $tutorat->getReferenceTutorat()]);
    }

}
