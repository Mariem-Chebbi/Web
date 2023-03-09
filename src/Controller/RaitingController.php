<?php

namespace App\Controller;

use App\Entity\Raiting;
use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class RaitingController extends AbstractController
{
    #[Route('/raiting', name: 'app_raiting')]
    public function index(): Response
    {
        return $this->render('raiting/index.html.twig', [
            'controller_name' => 'RaitingController',
        ]);
    }

    #[Route('/addRaiting/{id}', name: 'raiting_add')]
    public function add(Product $product,ManagerRegistry $doctrine): Response
    {
        $raiting = new Raiting();
        $raiting->setUser($this->getUser());
        $raiting->setProduct($product);
        $raiting->setRaiting('5');
        $em= $doctrine->getManager();
        $em->persist($raiting);
        $em->flush();

        return $this->redirectToRoute('afficheP', ['id' => $product->getId()]);
    }

    #[Route('/suppRaiting/{id}', name: 'Raiting_remove')]
    public function remove(Raiting $raiting,ManagerRegistry $doctrine): Response
    {
        $em= $doctrine->getManager();
        $em->remove($raiting);
        $em->flush();

        return $this->redirectToRoute('afficheP', ['id' => $raiting->getProduct()->getId()]);
    }
}
