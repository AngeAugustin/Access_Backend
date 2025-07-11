<?php

namespace App\Controller;

use App\Entity\Enfant;
use App\Entity\User; 
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request; 
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AddEnfantController extends AbstractController
{
    #[Route('/api/add_enfant', name: 'api_add_enfant', methods: ['POST'])]
    public function apiAddEnfant(Request $request, EntityManagerInterface $entityManager): JsonResponse
    { 
        $data = json_decode($request->getContent(), true);
    
        if ($data === null) {
            return new JsonResponse(['error' => 'Invalid JSON format'], Response::HTTP_BAD_REQUEST);
        }
    
        // Existence d'un enfant avec le même NPI
        $existingNPI = $entityManager->getRepository(Enfant::class)->findOneBy(['NPI_enfant' => $data['NPI_enfant']]);
        if ($existingNPI) {
            return new JsonResponse(['error' => 'Un enfant avec le même NPI existe déjà'], Response::HTTP_BAD_REQUEST);
        }

        // Récupération de l'utilisateur via le NPI
        $user = $entityManager->getRepository(User::class)->findOneBy(['NPI' => $data['NPI']]);
        if (!$user) {
            return new JsonResponse(['error' => 'Utilisateur non trouvé'], Response::HTTP_NOT_FOUND);
        }

        // Incrémentation du nombre d'enfants
        $user->setNombreEnfants($user->getNombreEnfants() + 1);

        // Enregistrement dans Enfant
        $enfant = new Enfant();
        $enfant->setNPI($data['NPI']);
        $enfant->setNPIEnfant($data['NPI_enfant']);
        $enfant->setNomEnfant($data['Nom_enfant']);
        $enfant->setPrenomEnfant($data['Prenom_enfant']);
        $enfant->setDateNaissance(new \DateTime($data['Date_naissance']));
        $enfant->setSexeEnfant($data['Sexe_enfant']);
        $enfant->setEcolePrecedente($data['Ecole_precedente']);
        $enfant->setClassePrecedente($data['Classe_precedente']);
        $enfant->setEcoleActuelle($data['Ecole_actuelle']);
        $enfant->setClasseActuelle($data['Classe_actuelle']);
        $enfant->setParentTuteur($data['Parent_tuteur']);
        $enfant->setMatieresPreferes($data['Matieres_preferes']);
        $enfant->setCentreInteret($data['Centre_interet']);
        $enfant->setNiveauFrancais($data['Niveau_francais']);
        $enfant->setNiveauAnglais($data['Niveau_anglais']);
        $enfant->setNiveauAllemand($data['Niveau_allemand']);
        $enfant->setNiveauEspagnol($data['Niveau_espagnol']);
        $enfant->setNiveauHistgeo($data['Niveau_histgeo']);
        $enfant->setNiveauMathematique($data['Niveau_mathematique']);
        $enfant->setNiveauPct($data['Niveau_pct']);
        $enfant->setNiveauPhilosophie($data['Niveau_philosophie']);
        $enfant->setNiveauSvt($data['Niveau_svt']);
        $enfant->setNiveauEconomie($data['Niveau_economie']);
        $enfant->setNiveauComptabilite($data['Niveau_comptabilite']);
        $enfant->setNiveauComptagenerale($data['Niveau_comptagenerale']);
        $enfant->setNiveauComptaanalytique($data['Niveau_comptaanalytique']);
        $enfant->setNiveauComptasociete($data['Niveau_comptasociete']);
        $enfant->setNiveauComptausuelle($data['Niveau_comptausuelle']);
        $enfant->setNiveauTA($data['Niveau_TA']);
        $enfant->setNiveauMathsfinanciere($data['Niveau_mathsfinanciere']);
        $enfant->setNiveauDroit($data['Niveau_droit']);
        $enfant->setNiveauMathsgenerale($data['Niveau_mathsgenerale']);
        $enfant->setNiveauFiscalite($data['Niveau_fiscalite']);

        $entityManager->persist($enfant);
        $entityManager->persist($user); // Persiste les changements sur l'utilisateur
        $entityManager->flush();
    
        return new JsonResponse([
            'Message' => 'Enfant ajouté avec succès',
            'Nom_enfant' => $enfant->getNomEnfant(),
            'Nombre_enfants' => $user->getNombreEnfants()
        ]);
    }
}
