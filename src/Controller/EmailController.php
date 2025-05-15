<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class EmailController extends AbstractController
{
    public function __construct(
    private readonly MailerInterface $mailer,
    ) {
    }

    #[Route('/email', name: 'app_email')]
    public function index(): Response
    {
        $this->mailer->send(
            (new Email())
                ->from('Acme <onboarding@resend.dev>')
                ->to('augustinfachehoun97@gmail.com')
                ->subject('Hello world')
                ->html('<strong>it works!</strong>')
        );
        return $this->render('email/index.html.twig', [
            'controller_name' => 'EmailController',
        ]);
    }
}
