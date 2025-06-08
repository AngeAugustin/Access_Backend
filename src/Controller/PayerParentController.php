<?php

namespace App\Controller;

use App\Entity\Paiement;
use App\Entity\PaiementParent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PayerParentController extends AbstractController
{
    #[Route('/api/payer_parent', name: 'payer_parent', methods: ['POST'])]
    public function payerParent(Request $request, EntityManagerInterface $entityManager, \Psr\Log\LoggerInterface $logger)
    {
        
        /* Adding webhook */ 
        $endpoint_secret = 'wh_sandbox_6iiscCZ20nlJHlyclHRdGkbA';
        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_X_FEDAPAY_SIGNATURE'];
        $event = null;

        try {
            $event = \FedaPay\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch(\FedaPay\Error\SignatureVerification $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }
        
        //Show info to
        $data = json_decode($payload)->entity->custom_metadata;
        $transac_id = json_decode($payload)->entity->id;

        // Log the event for debugging
        $logger->info('FedaPay Webhook Event', [
            'event' => $event->name,
            'data' => $data,
            'transaction_id' => $transac_id
        ]);

        // Handle the event
        switch ($event->name) {
            case 'transaction.created':
                // Transaction créée
                break;
            case 'transaction.approved':

                $Id_paiement = $data->Id_paiement;
                $Id_transaction = $transac_id;
                $Paiement = $data->Paiement;
                $NPI_payeur = $data->NPI_payeur;
                $Nom_payeur = $data->Nom_payeur;
                $Email_payeur = $data->Email_payeur;
                $Prenom_payeur = $data->Prenom_payeur;
                $Role_payeur = $data->Role_payeur;
                $Montant_paiement = $data->Montant_paiement;

                // Recherche du Paiement
                $paiement = $entityManager->getRepository(Paiement::class)->find($Id_paiement);

                if (!$paiement) {
                    return new JsonResponse(['message' => 'Paiement non trouvé'], 404);
                }

                $updated = false;
                $today = new \DateTime();

                // Trouver la correspondance Paiement1, Paiement2 ou Paiement3
                for ($i = 1; $i <= 3; $i++) {
                    $getPaiement = 'getPaiement' . $i;
                    $setStatut = 'setStatutPaiement' . $i;
                    $setDate = 'setDatePaiement' . $i;

                    if ($paiement->$getPaiement() === $Paiement) {
                        $paiement->$setStatut('Provisoire');
                        $paiement->$setDate($today);
                        $updated = true;
                        break;
                    }
                }

                if (!$updated) {
                    return new JsonResponse(['message' => 'Paiement envoyé ne correspond pas à un Paiement enregistré'], 404);
                }

                $entityManager->persist($paiement);

                // Création enregistrement PaiementParent
                $paiementParent = new PaiementParent();
                $paiementParent->setIdPaiement($Paiement);
                $paiementParent->setIdTransaction($Id_transaction);
                $paiementParent->setNPIPayeur($NPI_payeur);
                $paiementParent->setNomPayeur($Nom_payeur);
                $paiementParent->setPrenomPayeur($Prenom_payeur);
                $paiementParent->setRolePayeur($Role_payeur);
                $paiementParent->setEmailPayeur($Email_payeur);
                $paiementParent->setStatutPaiement('Effectué');
                $paiementParent->setDatePaiement($today->format('Y-m-d'));
                $paiementParent->setMontantPaiement($Montant_paiement);

                $entityManager->persist($paiementParent);
                $entityManager->flush();

                return new JsonResponse(['message' => 'Paiement parent enregistré avec succès']);
                // Transaction approuvée
                break;
            default:
                http_response_code(400);
                exit();
        }

        return new JsonResponse(['message' => 'Webhook reçu avec succès']);        
    }


    # Route pour créer une transaction avec FedaPay
    #[Route('/api/initier_transaction', name: 'initier_transaction', methods: ['POST'])]
    public function initierTransaction(Request $request): JsonResponse
    {
        // Configure FedaPay
        \FedaPay\FedaPay::setAccountId('acc_4847441598');
        \FedaPay\FedaPay::setApiKey('sk_sandbox_0SPLKw_Fy0feqqINjHUqB_DI');
        \FedaPay\FedaPay::setEnvironment('sandbox');

        $data = json_decode($request->getContent(), true);

        if (!$data
            || !isset($data['Id_paiement'], $data['Paiement'], $data['NPI_payeur'], $data['Nom_payeur'], $data['Prenom_payeur'], $data['Role_payeur'], $data['Montant_paiement'])) {
            return new JsonResponse(['message' => 'Données manquantes ou invalides'], 400);
        }

        $Id_paiement = $data['Id_paiement'];
        $Paiement = $data['Paiement'];
        $NPI_payeur = $data['NPI_payeur'];
        $Email_payeur = $data['Email_payeur'];
        $Nom_payeur = $data['Nom_payeur'];
        $Prenom_payeur = $data['Prenom_payeur'];
        $Role_payeur = $data['Role_payeur'];
        $Montant_paiement = $data['Montant_paiement'];

        try {
            $transaction = \FedaPay\Transaction::create([
                "description" => "Paiement de " . $Prenom_payeur . " " . $Nom_payeur,
                "amount" => $Montant_paiement,
                "currency" => ["iso" => "XOF"],
                "custom_metadata" => [
                    "Id_paiement" => $Id_paiement,
                    "NPI_payeur" => $NPI_payeur,
                    "Role_payeur" => $Role_payeur,
                    "Email_payeur" => $Email_payeur,
                    "Paiement" => $Paiement,
                    "Nom_payeur" => $Nom_payeur,
                    "Prenom_payeur" => $Prenom_payeur,
                    "Montant_paiement" => $Montant_paiement,
                ],
                "callback_url" => 'https://access-admin.vercel.app/resultpay/',
                "customer" => [
                    "firstname" => $Prenom_payeur,
                    "lastname" => $Nom_payeur,
                    "email" => $Email_payeur
                ]
            ]);

            // Retourner le token généré pour finaliser le paiement
            return new JsonResponse([ 
                'status' => 'success',
                'data' => $transaction->generateToken()
            ]);
        } catch (\Exception $ex) {
            // Gestion des erreurs FedaPay
            $message = "Une erreur est survenue.";

            // Vous pouvez personnaliser la gestion des erreurs ici selon le type d'exception
            if (strpos($ex->getMessage(), 'phone') !== false) {
                $message = "Le numéro de téléphone est invalide. ";
            }

            $message .= $ex->getMessage();

            return new JsonResponse([
                'status' => 'error',
                'message' => $message
            ], 500);
        } 
    }
}
