<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Services;
use App\Form\ServicesFormType;
use App\Repository\ServicesRepository;
use Doctrine\Persistence\ManagerRegistry;


class ServicesController extends AbstractController
{
    #[Route('/services', name: 'app_services')]
    public function index(): Response
    {
        return $this->render('services/addServices.html.twig', [
            'controller_name' => 'ServicesController',
        ]);
    }

    #[Route('/suppServices/{id}', name: 'supprimerServices')]

    public function suppServices(ManagerRegistry $doctrine,$id,ServicesRepository $repository)
      {
      //récupérer le Services à supprimer
          $Services= $repository->find($id);
      //récupérer l'entity manager
          $em= $doctrine->getManager();
          $em->remove($Services);
          $em->flush();
          return $this->redirectToRoute("app_addServices");///////////////////////
      } 

      #[Route('/updatServices/{id}', name: 'updatServices')]

    public function updatServices(ManagerRegistry $doctrine,$id,ServicesRepository $repository,Request $request)
      {
      //récupérer le Services à supprimer
      
          $c= $repository->findAll();
          $Services= $repository->find($id);
          $newServices= new Services();
          $form=$this->createForm(ServicesFormType::class,$newServices);
          $form->get('Libelle')->setData($Services->getLibelle());
          $form->get('Description')->setData($Services->getDescription());
         
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $file = $form['Icone']->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );
            $newServices->setIcone($fileName);
            $em =$doctrine->getManager() ;
            $Services->setIcone($newServices->getIcone());
            $Services->setDescription($newServices->getDescription());


            $em->flush();
            return $this->redirectToRoute("app_addServices");
        }
        else {
            // Form is not valid, retrieve the errors
            $errors = $form->getErrors(true, false);

            // Display the errors
            
        }
        return $this->render("services/addServices.html.twig", [
            'formClass' => $form->createView(),
            "Services"=>$c,
        ]);
      } 

      #[Route('/afficheServices', name: 'afficheServices')]

      public function showServices(ServicesRepository $repository)
      {
          $c= $repository->findAll();
          return $this->render("Services/showServices.html.twig",
          ["Services"=>$c]);
        }

             

 #[Route('/addServices', name: 'app_addServices')]
    public function addServices(ManagerRegistry $doctrine,Request $request,ServicesRepository $repository)
    {
        $c= $repository->findAll();
        $Services= new Services();
        $form=$this->createForm(ServicesFormType::class,$Services);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $file = $form['Icone']->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );
            $Services->setIcone($fileName);
            $em =$doctrine->getManager() ;
            $em->persist($Services);
            $em->flush();
            return $this->redirectToRoute("app_addServices");
        }
        else {
            // Form is not valid, retrieve the errors
            $errors = $form->getErrors();
        }
       
        return $this->render("services/addServices.html.twig", [
        'formClass' => $form->createView(),
        "Services"=>$c,
        
    ]);
     }
}
