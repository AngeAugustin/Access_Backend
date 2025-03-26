<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GetHistoriqueSeancesController extends AbstractController
{
    #[Route('/get/historique/seances', name: 'app_get_historique_seances')]
    public function index(): Response
    {
        return $this->render('get_historique_seances/index.html.twig', [
            'controller_name' => 'GetHistoriqueSeancesController',
        ]);
    }
}
