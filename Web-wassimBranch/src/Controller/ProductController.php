<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Form\ProductFormType;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;


class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(): Response
    {
        return $this->render('product/addProduct.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/suppProduct/{id}', name: 'supprimerP')]

    public function suppP(ManagerRegistry $doctrine,$id,ProductRepository $repository)
      {
      //récupérer le Product à supprimer
          $Product= $repository->find($id);
      //récupérer l'entity manager
          $em= $doctrine->getManager();
          $em->remove($Product);
          $em->flush();
          return $this->redirectToRoute("app_addProduct");///////////////////////
      } 

      #[Route('/updatProduct/{id}', name: 'updatP')]

    public function updatP(ManagerRegistry $doctrine,$id,ProductRepository $repository,Request $request)
      {
      //récupérer le Product à supprimer
      
          $c= $repository->findAll();
          $Product= $repository->find($id);
          $newProduct= new Product();
          $form=$this->createForm(ProductFormType::class,$newProduct);
          $form->get('libelle')->setData($Product->getLibelle());
          $form->get('description')->setData($Product->getDescription());
         
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $file = $form['image']->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );
            $newProduct->setImage($fileName);
            $em =$doctrine->getManager() ;
            $Product->setLibelle($newProduct->getLibelle());
            $Product->setDescription($newProduct->getDescription());
            $Product->setImage($newProduct->getImage());
            $em->flush();
            return $this->redirectToRoute("app_addProduct");
        }
        else {
            // Form is not valid, retrieve the errors
            $errors = $form->getErrors(true, false);

            // Display the errors
            foreach ($errors as $error) {
                $message = $error->getMessage();
            }
        }
        return $this->render("product/addProduct.html.twig", [
            'formClass' => $form->createView(),
            "Product"=>$c,
        ]);
      } 

      /*#[Route('/updatProduct/{id}', name: 'updatP')]

    public function updatP(ManagerRegistry $doctrine,$id,ProductRepository $repository,Request $request)
      {
      //récupérer le Product à supprimer
          $Product= $repository->find($id);
          $newProduct= new Product();
          $form=$this->createForm(ProductFormType::class,$newProduct);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em =$doctrine->getManager() ;
            $Product->setLibelle($newProduct->getLibelle());
            $Product->setDescription($newProduct->getDescription());
            $Product->setImage($newProduct->getImage());
            $em->flush();
            return $this->redirectToRoute("afficheP");
        }
        return $this->renderForm("Product/updateProduct.html.twig",/////////////////////////////////////////////
        array("formClass"=>$form));//////////////////////////
      } */

      #[Route('/afficheProduct', name: 'afficheP')]

      public function showP(ProductRepository $repository)
      {
          $c= $repository->findAll();
          return $this->render("Product/showProduct.html.twig",
          ["Product"=>$c]);
        }


        

         
             

 #[Route('/addProduct', name: 'app_addProduct')]
    public function addProduct(ManagerRegistry $doctrine,Request $request,ProductRepository $repository)
    {
        $c= $repository->findAll();
        $Product= new Product();
        $form=$this->createForm(ProductFormType::class,$Product);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $file = $form['image']->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );
            $Product->setImage($fileName);
            $em =$doctrine->getManager() ;
            $em->persist($Product);
            $em->flush();
            return $this->redirectToRoute("app_addProduct");
        }
        else {
            // Form is not valid, retrieve the errors
            $errors = $form->getErrors();
        }
       
        return $this->render("product/addProduct.html.twig", [
        'formClass' => $form->createView(),
        "Product"=>$c,
        
    ]);
     }
}
