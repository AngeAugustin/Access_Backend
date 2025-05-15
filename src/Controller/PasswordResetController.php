<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

class PasswordResetController extends AbstractController
{
    #[Route('/api/reset-password', name: 'api_reset_password', methods: ['POST'])]
    public function resetPassword(
        Request $request,
        EntityManagerInterface $em,
        MailerInterface $mailer
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $Email = $data['Email'] ?? null;
        $NPI = $data['NPI'] ?? null;

        if (!$Email || !$NPI) {
            return $this->json(['error' => 'Email and NPI are required.'], 400);
        }

        $user = $em->getRepository(User::class)->findOneBy([
            'Email' => $Email,
            'NPI' => $NPI,
        ]);

        if (!$user) {
            return $this->json(['error' => 'User not found.'], 404);
        }

        // Génère un nouveau code secret aléatoire
        $codeSecret = substr(Uuid::v4()->toRfc4122(), 0, 8);
        #$codeSecret = bin2hex(random_bytes(16));

        $user->setCodeSecret($codeSecret);
        $em->flush();

        $emailMessage = (new Email())
            ->from('Acme <onboarding@resend.dev>')
            ->to($user->getEmail())
            ->subject('Code de réinitialisation')
            ->html("<p>Bonjour {$user->getFirstname()},</p><p>Votre code de réinitialisation est : <strong>{$codeSecret}</strong></p>");

        $mailer->send($emailMessage);

        return $this->json(['message' => 'Code de réinitialisation envoyé.']);
    }
}
