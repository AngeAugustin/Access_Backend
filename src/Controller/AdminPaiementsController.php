<?php

namespace App\Controller;

use App\Entity\Paiement;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class AdminPaiementsController extends AbstractController
{
    #[Route('/api/admin_paiements', name: 'paiements_admin', methods: ['GET'])]
    public function paiementsAdmin(EntityManagerInterface $entityManager): JsonResponse
    {
        $today = new \DateTime();
        $provisoire = [];
        $effectues = [];

        $paiements = $entityManager->getRepository(Paiement::class)->findAll();

        foreach ($paiements as $paiement) {
            for ($i = 1; $i <= 3; $i++) {
                $getDate = 'getDatePaiement' . $i;
                $getStatut = 'getStatutPaiement' . $i;
                $getMontant = 'getMontantPaiement' . $i;
                $getPaiement = 'getPaiement' . $i;

                $date = $paiement->$getDate();
                $statut = $paiement->$getStatut();

                if ($date instanceof \DateTimeInterface) {
                    // Récupération de l'utilisateur éducateur
                    $educateur = $entityManager->getRepository(User::class)->find($paiement->getNPIEducateur());

                    // Si l'éducateur existe, on extrait les infos
                    $educateurNom = $educateur ? $educateur->getName() : 'Inconnu';
                    $educateurPrenom = $educateur ? $educateur->getFirstname() : 'Inconnu';

                    // Paiement en attente dans 5 jours ou moins
                    if ($statut === 'Provisoire') {
                        $interval = $today->diff($date);
                        $daysDiff = (int) $interval->format('%r%a');
                        if ($daysDiff >= 0 && $daysDiff <= 5) {
                            $provisoire[] = [
                                'Id_paiement' => $paiement->getIdPaiement(),
                                'Nom_educateur' => $educateurNom,
                                'Prenom_educateur' => $educateurPrenom,
                                'Montant_paiement' => $paiement->$getMontant(),
                                'Statut_paiement' => $statut,
                                'Date_paiement' => $date->format('Y-m-d'),
                                'Paiement' => $paiement->$getPaiement(),
                            ];
                        }
                    }

                    // Paiement effectué 
                    if ($statut === 'Effectué') {
                        $effectues[] = [
                            'Id_paiement' => $paiement->getIdPaiement(),
                            'Nom_educateur' => $educateurNom,
                            'Prenom_educateur' => $educateurPrenom,
                            'Statut_paiement' => $statut,
                            'Montant_paiement' => $paiement->$getMontant(),
                            'Date_paiement' => $date->format('Y-m-d'),
                            'Paiement' => $paiement->$getPaiement(),
                        ];
                    }
                }
            }
        }

        return new JsonResponse([
            'provisoire' => $provisoire,
            'effectues' => $effectues
        ]);
    }
}
