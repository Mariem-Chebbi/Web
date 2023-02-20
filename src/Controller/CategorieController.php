<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categorie;
use App\Form\CategorieFormType;
use App\Repository\CategorieRepository;
use Doctrine\Persistence\ManagerRegistry;


class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    public function index(): Response
    {
        return $this->render('categorie/addCategorie.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }

    #[Route('/suppCategorie/{id}', name: 'supprimerC')]

    public function suppC(ManagerRegistry $doctrine,$id,CategorieRepository $repository)
      {
      //récupérer le Categorie à supprimer
          $Categorie= $repository->find($id);
      //récupérer l'entity manager
          $em= $doctrine->getManager();
          $em->remove($Categorie);
          $em->flush();
          return $this->redirectToRoute("app_addCategorie");///////////////////////
      } 

      #[Route('/updatCategorie/{id}', name: 'updatC')]

    public function updatC(ManagerRegistry $doctrine,$id,CategorieRepository $repository,Request $request)
      {
      //récupérer le Categorie à supprimer
      
          $c= $repository->findAll();
          $Categorie= $repository->find($id);
          $newCategorie= new Categorie();
          $form=$this->createForm(CategorieFormType::class,$newCategorie);
          $form->get('Libelle')->setData($Categorie->getLibelle());
         
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            
            $em =$doctrine->getManager() ;
            $Categorie->setLibelle($newCategorie->getLibelle());
            $em->flush();
            return $this->redirectToRoute("app_addCategorie");
        }
        else {
            // Form is not valid, retrieve the errors
            $errors = $form->getErrors(true, false);

            // Display the errors
            foreach ($errors as $error) {
                $message = $error->getMessage();
            }
        }
        return $this->render("categorie/index.html.twig", [
            'formClass' => $form->createView(),
            "Categorie"=>$c,
        ]);
      } 

    

      #[Route('/afficheCategorie', name: 'afficheB')]

      public function showP(CategorieRepository $repository)
      {
          $c= $repository->findAll();
          return $this->render("Categorie/index.html.twig",
          ["Categorie"=>$c]);
        }


        

         
             

 #[Route('/addCategorie', name: 'app_addCategorie')]
    public function addCategorie(ManagerRegistry $doctrine,Request $request,CategorieRepository $repository)
    {
        $c= $repository->findAll();
        $Categorie= new Categorie();
        $form=$this->createForm(CategorieFormType::class,$Categorie);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            
            $em =$doctrine->getManager() ;
            $em->persist($Categorie);
            $em->flush();
            return $this->redirectToRoute("app_addCategorie");
        }
        else {
            // Form is not valid, retrieve the errors
            $errors = $form->getErrors();
        }
       
        return $this->render("categorie/index.html.twig", [
        'formClass' => $form->createView(),
        "Categorie"=>$c,
        
    ]);
     }
}
