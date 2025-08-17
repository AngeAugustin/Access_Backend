<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class StopTutoratController extends AbstractController
{
    #[Route('/api/stop_tutorat', name: 'api_stop_tutorat', methods: ['POST'])]
    public function stopTutorat(\Symfony\Component\HttpFoundation\Request $request, \Doctrine\ORM\EntityManagerInterface $entityManager): \Symfony\Component\HttpFoundation\JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $reference = $data['Reference_tutorat'] ?? null;
        if (!$reference) {
            return $this->json(['error' => 'Reference_tutorat manquant'], 400);
        }

        $tutorat = $entityManager->getRepository(\App\Entity\Tutorat::class)->findOneBy(['Reference_tutorat' => $reference]);
        if (!$tutorat) {
            return $this->json(['error' => 'Tutorat non trouvé'], 404);
        }

        $tutorat->setStatutTutorat('Terminé');
        $tutorat->setDateFinTutorat(new \DateTime());
        $entityManager->flush();

        return $this->json([
            'message' => 'Tutorat arrêté avec succès',
            'Reference_tutorat' => $reference,
            'Statut_tutorat' => $tutorat->getStatutTutorat(),
            'Date_fin_tutorat' => $tutorat->getDateFinTutorat()?->format('Y-m-d'),
        ]);
    }
}
