<?php

namespace App\Controller;

use App\Entity\Favorite;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\FavoriteRepository;
use App\Repository\ProductRepository;




class FavoriteController extends AbstractController
{
    #[Route('/addFavorit/{id}', name: 'favorite_add')]
    public function add(Product $product,ManagerRegistry $doctrine): Response
    {
        $favorite = new Favorite();
        $favorite->setUser($this->getUser());
        $favorite->setProduct($product);
        $em= $doctrine->getManager();
        $em->persist($favorite);
        $em->flush();

        return $this->redirectToRoute('afficheP', ['id' => $product->getId()]);
    }

    #[Route('/suppFavorit/{id}', name: 'favorite_remove')]
    public function remove(Favorite $favorite,ManagerRegistry $doctrine): Response
    {
        $em= $doctrine->getManager();
        $em->remove($favorite);
        $em->flush();

        return $this->redirectToRoute('afficheP', ['id' => $favorite->getProduct()->getId()]);
    }


    #[Route('/addFavorit2/{id}', name: 'favorite_add2')]
    public function add2(Product $product,ManagerRegistry $doctrine): Response
    {
        $favorite = new Favorite();
        $favorite->setUser($this->getUser());
        $favorite->setProduct($product);
        $em= $doctrine->getManager();
        $em->persist($favorite);
        $em->flush();

        return $this->redirectToRoute('afficheDetailsP', ['id' => $product->getId()]);
    }

    #[Route('/suppFavorit2/{id}', name: 'favorite_remove2')]
    public function remove2(Favorite $favorite,ManagerRegistry $doctrine): Response
    {
        $em= $doctrine->getManager();
        $em->remove($favorite);
        $em->flush();

        return $this->redirectToRoute('afficheDetailsP', ['id' => $favorite->getProduct()->getId()]);
    }

    #[Route('/afficheFavorite', name: 'favorite_affiche2')]
    public function index(FavoriteRepository $favoriteRepository,ProductRepository $productRepository): Response
    {
        $favorites = $favoriteRepository->findBy(['user' => $this->getUser()]);
        //$Product[] = new Product;
        $favoritid = new Favorite;
        foreach($favorites as $favorite)
        {
            $favoritid= $favoriteRepository->find($favorite->getId());
           // $prodid = $favoriteRepository->find($favorite->getProduct()->getId());
            $Product[]=[
                'id' => $favoritid->getProduct()->getId(),
                'quantite' => $favoritid->getProduct()->getQuantite(),
                'libelle' => $favoritid->getProduct()->getLibelle(),
                'description' => $favoritid->getProduct()->getDescription(),
                'image' => $favoritid->getProduct()->getImage(),
        ];
           // $Products[]=[$Product];
        }


        return $this->render('favorite/index.html.twig', [
            'Product' => $Product,
        ]);
    }
}

