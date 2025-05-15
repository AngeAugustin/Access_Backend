<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CodeCheckingController extends AbstractController
{
    #[Route('/api/check-code', name: 'api_check_code', methods: ['POST'])]
    public function checkCode(
        Request $request,
        EntityManagerInterface $em
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        $NPI = $data['NPI'] ?? null;
        $Code_secret = $data['Code_secret'] ?? null;

        if (!$NPI || !$Code_secret) {
            return $this->json(['error' => 'NPI et Code sont requis.'], 400);
        }

        $user = $em->getRepository(User::class)->findOneBy([
            'NPI' => $NPI,
            'Code_secret' => $Code_secret,
        ]);

        if (!$user) {
            return $this->json(['error' => 'Code incorrect ou NPI invalide.'], 401);
        }

        return $this->json(['message' => 'Code validé avec succès.']);
    }
}
