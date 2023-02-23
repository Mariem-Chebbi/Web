<?php

namespace App\Controller;
namespace App\Controller;
use App\Entity\Sponser;
use App\Form\SponserType;
use App\Repository\SponserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SponsorfrontController extends AbstractController
{
    #[Route('/sponsorfront', name: 'app_sponsorfront')]
    public function index(): Response
    {
        return $this->render('sponsorfront/index.html.twig', [
            'controller_name' => 'SponsorfrontController',
        ]);
    }
    #[Route('/frontsponsor', name: 'frontsponsor')]

    public function frontsponsor(SponserRepository $repository)
    {
        $sponser= $repository->findAll();
        return $this->render("sponsorfront/frontsponsor.html.twig",
        ["sponsers"=>$sponser]);
      }

      #[Route('/showsponsor/{id}', name: 'showsponsor')]

    public function showsponsor(SponserRepository $repository,$id)
    {
        $sponser= $repository->find($id);
        return $this->render("sponsorfront/showsponsor.html.twig",
        ["sponsers"=>$sponser]);
      }
}
