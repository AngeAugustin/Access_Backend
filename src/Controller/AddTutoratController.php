<?php

namespace App\Controller;

use App\Entity\Tutorat;
use App\Entity\Paiement;
use App\Entity\Tarif;
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

        // Vérifie si une référence existe déjà
        $existingReference = $entityManager->getRepository(Tutorat::class)->findOneBy([
            'Reference_tutorat' => $data['Reference_tutorat']
        ]);
        if ($existingReference) {
            return new JsonResponse(['error' => 'Une relation de tutorat avec la même référence existe déjà'], Response::HTTP_BAD_REQUEST);
        }

        // Vérifie la présence du tarif pour la classe actuelle
        $tarif = $entityManager->getRepository(Tarif::class)->findOneBy([
            'Classe_actuelle' => $data['Classe_actuelle']
        ]);

        if (!$tarif) {
            return new JsonResponse(['error' => 'Tarif non défini pour la classe actuelle'], Response::HTTP_BAD_REQUEST);
        }

        // Enregistrement dans Tutorat
        $tutorat = new Tutorat();
        $tutorat->setReferenceTutorat($data['Reference_tutorat']);
        $tutorat->setNPIParent($data['NPI_parent']);
        $tutorat->setNPIEducateur($data['NPI_educateur']);
        $tutorat->setNPIEnfant($data['NPI_enfant']);
        $tutorat->setDureeTutorat($data['Duree_tutorat']);
        $tutorat->setSeance1($data['Seance1']);
        $tutorat->setSeance2($data['Seance2']);
        $tutorat->setStatutTutorat('En cours');
        $tutorat->setDateTutorat(new \DateTime());

        $entityManager->persist($tutorat);
        $entityManager->flush();

        // Calculs liés au tarif
        $Nbre_seances_semaine = $tarif->getNbreSeancesSemaine();
        $Nbre_heure_seance = $tarif->getNbreHeureSeance();
        $Tarif_horaire = $tarif->getTarifHoraire();
        $Duree_tutorat = $data['Duree_tutorat'];
        $Classe_actuelle = $data['Classe_actuelle'];

        $paiement = new Paiement();
        $paiement->setIdPaiement(random_int(1000000000, 9999999999));
        $paiement->setReferenceTutorat($data['Reference_tutorat']);
        $paiement->setNPIParent($data['NPI_parent']);
        $paiement->setNPIEducateur($data['NPI_educateur']);
        $paiement->setDureeTutorat($Duree_tutorat);
        $paiement->setClasseActuelle($Classe_actuelle);

        $dateBase = new \DateTime();
        $statut = 'En attente';

        if ($Duree_tutorat <= 4) {
            $paiement->setNbrePaiements(1);
            $montant = $Nbre_heure_seance * $Nbre_seances_semaine * $Duree_tutorat * $Tarif_horaire;

            $paiement->setMontantPaiement1($montant);
            $paiement->setStatutPaiement1($statut);
            $paiement->setDatePaiement1((clone $dateBase)->modify('+1 month'));

        } else {
            $nbrePaiements = intval(ceil($Duree_tutorat / 4));
            $paiement->setNbrePaiements($nbrePaiements);
            $montant = $Nbre_heure_seance * $Nbre_seances_semaine * 4 * $Tarif_horaire;

            $currentDate = clone $dateBase;
            for ($i = 1; $i <= $nbrePaiements; $i++) {
                $currentDate->modify('+1 month');
                $setterMontant = 'setMontantPaiement' . $i;
                $setterStatut = 'setStatutPaiement' . $i;
                $setterDate   = 'setDatePaiement' . $i;

                if (method_exists($paiement, $setterMontant) && method_exists($paiement, $setterStatut) && method_exists($paiement, $setterDate)) {
                    $paiement->$setterMontant($montant);
                    $paiement->$setterStatut($statut);
                    $paiement->$setterDate(clone $currentDate);
                }
            }
        }

        $entityManager->persist($paiement);
        $entityManager->flush();

        return new JsonResponse([
            'Message' => 'Relation de tutorat créée avec succès',
            'Reference_tutorat' => $tutorat->getReferenceTutorat()
        ]);
    }
}
