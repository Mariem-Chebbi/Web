<?php

namespace App\Controller;

use App\Entity\CreneauHoraire;
use App\Form\AddCreneauHoraireType;
use App\Form\EditCreneauHoraireType;
use App\Repository\CreneauHoraireRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/creneau-horaire/add', name: 'add_creneau')]
    public function add(ManagerRegistry $doctrine, Request $request): Response
    {
        $creneau = new CreneauHoraire();
        $form = $this->createForm(AddCreneauHoraireType::class, $creneau);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $cr = $form->getData();
            //dd($cr);
            if ($cr->isEtat() == true) {
                $creneau->setHeureDebut(0);
                $creneau->setHeureFin(0);
            }
            $em = $doctrine->getManager();
            $em->persist($creneau);
            $em->flush();
            return $this->redirectToRoute('list_creneau');
        }
        return $this->render('creneau_horaire/add.html.twig', [
            'formAdd' => $form->createView(),
        ]);
    }


    #[Route('/creneau-horaire/list', name: 'list_creneau')]
    public function list(CreneauHoraireRepository $repo): Response
    {
        $creneaux = $repo->findAll();

        $order = array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi");

        usort($creneaux, function ($a, $b) use ($order) {
            $posA = array_search($a->getJour(), $order);
            $posB = array_search($b->getJour(), $order);
            return $posA - $posB;
        });
        //dd($creneaux);

        return $this->render('creneau_horaire/list.html.twig', [
            'creneaux' => $creneaux,
        ]);
    }

    #[Route('/creneau-horaire/edit/{id}', name: 'edit_creneau')]
    public function edit(CreneauHoraire $creneau, ManagerRegistry $doctrine, Request $request): Response
    {
        $entityManager = $doctrine->getManager();

        $form = $this->createForm(EditCreneauHoraireType::class, $creneau);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('list_creneau');
        }
        return $this->renderForm('creneau_horaire/edit.html.twig', [
            'formEdit' => $form,
            'creneau' => $creneau
        ]);
    }
}
