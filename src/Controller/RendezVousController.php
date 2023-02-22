<?php

namespace App\Controller;

use App\Entity\RendezVous;
use App\Form\RendezVousType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RendezVousController extends AbstractController
{
    #[Route('/rendez/vous', name: 'app_rendez_vous')]
    public function index(): Response
    {
        return $this->render('rendez_vous/index.html.twig', [
            'controller_name' => 'RendezVousController',
        ]);
    }


    #[Route('/rdv/add', name: 'add_rdv')]
    public function add(ManagerRegistry $doctrine, Request $request): Response
    {
        $rdv = new RendezVous();
        $form = $this->createForm(RendezVousType::class, $rdv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($rdv);
            $em->flush();
            //return $this->redirectToRoute('list_creneau');
        }

        return $this->renderForm('rendez_vous/add.html.twig', [
            'formAdd' => $form,
        ]);
    }
}
