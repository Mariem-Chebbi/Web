<?php
namespace App\Controller;
// src/Controller/WelcomeController.php

use App\Service\EmailService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;


class MailerController extends AbstractController
{
    #[Route('/mailer', name: 'app_mailer')]
    public function index(MailerInterface $mailer): Response
    {
        $email = new EmailService('john.doe@example.com');
        $mailer->send($email);

        return $this->render('welcome/index.html.twig');
    }
}
