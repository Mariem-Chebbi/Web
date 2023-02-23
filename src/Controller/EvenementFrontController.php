<?php

namespace App\Controller;
use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EvenementFrontController extends AbstractController
{
    #[Route('/evenement/front', name: 'app_evenement_front')]
    public function index(): Response
    {
        return $this->render('evenement_front/index.html.twig', [
            'controller_name' => 'EvenementFrontController',
        ]);
    }
    #[Route('/frontevent', name: 'frontevent')]

      public function frontevent(EvenementRepository $repository)
      {
          $evenement= $repository->findAll();
          return $this->render("evenement_front/frontevent.html.twig",
          ["evenements"=>$evenement]);
        }

        #[Route('/showevent/{id}', name: 'showevent')]

      public function showevent(EvenementRepository $repository,$id)
      {
          $evenement= $repository->find($id);
          return $this->render("evenement_front/showevent.html.twig",
          ["evenements"=>$evenement]);
        }
}
