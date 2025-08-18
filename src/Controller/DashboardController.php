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

            // Evolution du nombre de paiements effectués par mois (Parents)
            $paiementsParentParMois = $paiementParentRepository->createQueryBuilder('p')
                ->select("SUBSTRING(p.Date_paiement, 1, 7) AS mois, COUNT(p.Id_paiement) AS total")
                ->where("p.Statut_paiement = 'Effectué'")
                ->groupBy('mois')
                ->orderBy('mois', 'ASC')
                ->getQuery()
                ->getResult();

            // Evolution du nombre de paiements effectués par mois (Admins)
            $paiementsAdminParMois = $paiementAdminRepository->createQueryBuilder('p')
                ->select("SUBSTRING(p.Date_paiement, 1, 7) AS mois, COUNT(p.Id_paiement) AS total")
                ->where("p.Statut_paiement = 'Effectué'")
                ->groupBy('mois')
                ->orderBy('mois', 'ASC')
                ->getQuery()
                ->getResult();

            // Evolution du nombre d'inscrits par mois (Educateurs)
            $educateursParMois = $userRepository->createQueryBuilder('u')
                ->select("FUNCTION('DATE_FORMAT', u.Date_inscription, '%Y-%m') AS mois, COUNT(u.NPI) AS total")
                ->where("u.Role = 'EDUCATEUR'")
                ->groupBy('mois')
                ->orderBy('mois', 'ASC')
                ->getQuery()
                ->getResult();

            // Evolution du nombre d'inscrits par mois (Parents)
            $parentsParMois = $userRepository->createQueryBuilder('u')
                ->select("FUNCTION('DATE_FORMAT', u.Date_inscription, '%Y-%m') AS mois, COUNT(u.NPI) AS total")
                ->where("u.Role = 'PARENT'")
                ->groupBy('mois')
                ->orderBy('mois', 'ASC')
                ->getQuery()
                ->getResult();

            // Evolution du nombre d'inscrits par mois (Enfants)
            $enfantsParMois = $enfantRepository->createQueryBuilder('e')
                ->select("FUNCTION('DATE_FORMAT', e.Date_naissance, '%Y-%m') AS mois, COUNT(e.NPI_enfant) AS total")
                ->groupBy('mois')
                ->orderBy('mois', 'ASC')
                ->getQuery()
                ->getResult();
        return $this->json([
            'nbEducateurs' => $nbEducateurs,
            'nbParents' => $nbParents,
            'nbEnfants' => $nbEnfants,
            'nbEducateursNouveaux' => $educateursNouveaux,
            'nbPaiementsParent' => $nbPaiementsParent,
            'nbPaiementsAdmin' => $nbPaiementsAdmin,
                'paiementsParentParMois' => $paiementsParentParMois,
                'paiementsAdminParMois' => $paiementsAdminParMois,
                'educateursParMois' => $educateursParMois,
                'parentsParMois' => $parentsParMois,
                'enfantsParMois' => $enfantsParMois,
            'nbReclamations' => $nbReclamations,
        ]);
    }
}
