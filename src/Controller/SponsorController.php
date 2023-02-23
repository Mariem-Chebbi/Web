<?php

namespace App\Controller;

use App\Entity\Sponser;
use App\Form\SponserType;
use App\Repository\SponserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/sponsor')]
class SponsorController extends AbstractController
{
    #[Route('/', name: 'app_sponsor_index', methods: ['GET'])]
    public function index(SponserRepository $sponserRepository): Response
    {
        return $this->render('sponsor/index.html.twig', [
            'sponsers' => $sponserRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_sponsor_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SponserRepository $sponserRepository): Response
    {
        $sponser = new Sponser();
        $form = $this->createForm(SponserType::class, $sponser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sponserRepository->save($sponser, true);

            return $this->redirectToRoute('app_sponsor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sponsor/new.html.twig', [
            'sponser' => $sponser,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sponsor_show', methods: ['GET'])]
    public function show(Sponser $sponser): Response
    {
        return $this->render('sponsor/show.html.twig', [
            'sponser' => $sponser,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_sponsor_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Sponser $sponser, SponserRepository $sponserRepository): Response
    {
        $form = $this->createForm(SponserType::class, $sponser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sponserRepository->save($sponser, true);

            return $this->redirectToRoute('app_sponsor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sponsor/edit.html.twig', [
            'sponser' => $sponser,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sponsor_delete', methods: ['POST'])]
    public function delete(Request $request, Sponser $sponser, SponserRepository $sponserRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sponser->getId(), $request->request->get('_token'))) {
            $sponserRepository->remove($sponser, true);
        }

        return $this->redirectToRoute('app_sponsor_index', [], Response::HTTP_SEE_OTHER);
    }
}
