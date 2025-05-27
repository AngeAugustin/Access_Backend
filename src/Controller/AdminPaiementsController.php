<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminPaiementsController extends AbstractController
{
    #[Route('/admin/paiements', name: 'app_admin_paiements')]
    public function index(): Response
    {
        return $this->render('admin_paiements/index.html.twig', [
            'controller_name' => 'AdminPaiementsController',
        ]);
    }
}
