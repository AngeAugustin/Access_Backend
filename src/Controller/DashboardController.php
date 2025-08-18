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

    // Comptes et dates pour les graphes
    $paiementsParentEffectues = $paiementParentRepository->findBy(['Statut_paiement' => 'Effectué']);
    $paiementsAdminEffectues = $paiementAdminRepository->findBy(['Statut_paiement' => 'Effectué']);

    $datesPaiementsParent = array_map(fn($p) => $p->getDatePaiement(), $paiementsParentEffectues);
    $datesPaiementsAdmin = array_map(fn($p) => $p->getDatePaiement(), $paiementsAdminEffectues);

    $educateurs = $userRepository->findBy(['Role' => 'EDUCATEUR']);
    $parents = $userRepository->findBy(['Role' => 'PARENT']);
    $enfants = $enfantRepository->findAll();

    $datesInscriptionEducateurs = array_map(fn($u) => $u->getDateInscription(), $educateurs);
    $datesInscriptionParents = array_map(fn($u) => $u->getDateInscription(), $parents);
    $datesInscriptionEnfants = array_map(fn($e) => $e->getDateInscription(), $enfants);
        return $this->json([
            'nbEducateurs' => $nbEducateurs,
            'nbParents' => $nbParents,
            'nbEnfants' => $nbEnfants,
            'nbEducateursNouveaux' => $educateursNouveaux,
            'nbPaiementsParent' => $nbPaiementsParent,
            'nbPaiementsAdmin' => $nbPaiementsAdmin,
            'nbPaiementsParentEffectues' => count($paiementsParentEffectues),
            'datesPaiementsParent' => $datesPaiementsParent,
            'nbPaiementsAdminEffectues' => count($paiementsAdminEffectues),
            'datesPaiementsAdmin' => $datesPaiementsAdmin,
            'nbInscriptionEducateurs' => count($educateurs),
            'datesInscriptionEducateurs' => $datesInscriptionEducateurs,
            'nbInscriptionParents' => count($parents),
            'datesInscriptionParents' => $datesInscriptionParents,
            'nbInscriptionEnfants' => count($enfants),
            'datesInscriptionEnfants' => $datesInscriptionEnfants,
            'nbReclamations' => $nbReclamations,
        ]);
    }
}
