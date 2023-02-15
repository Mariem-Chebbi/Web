<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreneauHoraireController extends AbstractController
{
    #[Route('/creneau-horaire', name: 'app_creneau_horaire')]
    public function index(): Response
    {
        return $this->render('creneau_horaire/index.html.twig', [
            'controller_name' => 'CreneauHoraireController',
        ]);
    }
}
