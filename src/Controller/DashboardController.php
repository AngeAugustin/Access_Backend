<?php

namespace App\Controller;

use App\Repository\EnfantRepository;
use App\Repository\PaiementAdminRepository;
use App\Repository\PaiementParentRepository;
use App\Repository\ReclamationRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class DashboardController extends AbstractController
{
    #[Route('/api/dashboard', name: 'app_dashboard', methods: ['GET'])]
    public function index(
        UserRepository $userRepository,
        EnfantRepository $enfantRepository,
        PaiementParentRepository $paiementParentRepository,
        PaiementAdminRepository $paiementAdminRepository,
        ReclamationRepository $reclamationRepository
    ): Response {
        $nbEducateurs = $userRepository->count(['Role' => 'EDUCATEUR']);
        $nbParents = $userRepository->count(['Role' => 'PARENT']);
        $nbEnfants = $enfantRepository->count([]);
        $educateursNouveaux = $userRepository->count(['Role' => 'EDUCATEUR', 'Statut_profil' => 'Nouveau']);
        $nbPaiementsParent = $paiementParentRepository->count(['Statut_paiement' => 'Effectué']);
        $nbPaiementsAdmin = $paiementAdminRepository->count(['Statut_paiement' => 'Effectué']);
        $nbReclamations = $reclamationRepository->count([]);

    // Données brutes pour les graphes
    $paiementsParentBrut = $paiementParentRepository->findAll();
    $paiementsAdminBrut = $paiementAdminRepository->findAll();
    $usersBrut = $userRepository->findAll();
    $enfantsBrut = $enfantRepository->findAll();
        return $this->json([
            'nbEducateurs' => $nbEducateurs,
            'nbParents' => $nbParents,
            'nbEnfants' => $nbEnfants,
            'nbEducateursNouveaux' => $educateursNouveaux,
            'nbPaiementsParent' => $nbPaiementsParent,
            'nbPaiementsAdmin' => $nbPaiementsAdmin,
            'paiementsParentBrut' => $paiementsParentBrut,
            'paiementsAdminBrut' => $paiementsAdminBrut,
            'usersBrut' => $usersBrut,
            'enfantsBrut' => $enfantsBrut,
            'nbReclamations' => $nbReclamations,
        ]);
    }
}
