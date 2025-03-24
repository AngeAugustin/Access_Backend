<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class GetEnfantAssigneController extends AbstractController
{
    #[Route('/get/enfant/assigne', name: 'app_get_enfant_assigne')]
    public function index(): Response
    {
        return $this->render('get_enfant_assigne/index.html.twig', [
            'controller_name' => 'GetEnfantAssigneController',
        ]);
    }
}
