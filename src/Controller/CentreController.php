<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Centre;
use App\Form\CentreFormType;
use App\Repository\CentreRepository;
use Doctrine\Persistence\ManagerRegistry;


class CentreController extends AbstractController
{
    #[Route('/centre', name: 'app_centre')]
    public function index(): Response
    {
        return $this->render('centre/addCentre.html.twig', [
            'controller_name' => 'CentreController',
        ]);
    }

    #[Route('/suppCentre/{id}', name: 'supprimerCentre')]

    public function suppCentre(ManagerRegistry $doctrine,$id,CentreRepository $repository)
      {
      //récupérer le Centre à supprimer
          $Centre= $repository->find($id);
      //récupérer l'entity manager
          $em= $doctrine->getManager();
          $em->remove($Centre);
          $em->flush();
          return $this->redirectToRoute("app_addCentre");///////////////////////
      } 

      #[Route('/updatCentre/{id}', name: 'updatCentre')]

    public function updatCentre(ManagerRegistry $doctrine,$id,CentreRepository $repository,Request $request)
      {
      //récupérer le Centre à supprimer
      
          $c= $repository->findAll();
          $Centre= $repository->find($id);
          $newCentre= new Centre();
          $form=$this->createForm(CentreFormType::class,$newCentre);
          $form->get('Nom_social')->setData($Centre->getNomSocial());
          $form->get('Aderesse')->setData($Centre->getAderesse());
          $form->get('Ville')->setData($Centre->getVille());
          $form->get('Description')->setData($Centre->getDescription());
          $form->get('Tel1')->setData($Centre->getTel1());
          $form->get('Tel2')->setData($Centre->getTel2());
         
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $file = $form['Logo']->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );
            $newCentre->setLogo($fileName);
            $em =$doctrine->getManager() ;
            $Centre->setAderesse($newCentre->getAderesse());
            $Centre->setDescription($newCentre->getDescription());
            $Centre->setTel1($newCentre->getTel1());
            $Centre->setTel2($newCentre->getTel2());
            $Centre->setNomSocial($newCentre->getNomSocial());
            $Centre->setLogo($newCentre->getLogo());


            $em->flush();
            return $this->redirectToRoute("app_addCentre");
        }
        else {
            // Form is not valid, retrieve the errors
            $errors = $form->getErrors(true, false);

            // Display the errors
            
        }
        return $this->render("centre/addCentre.html.twig", [
            'formClass' => $form->createView(),
            "Centre"=>$c,
        ]);
      } 

      #[Route('/afficheCentre', name: 'afficheCentre')]

      public function showCentre(CentreRepository $repository)
      {
          $c= $repository->findAll();
          return $this->render("Centre/showCentre.html.twig",
          ["Centre"=>$c]);
        }


        

         
             

 #[Route('/addCentre', name: 'app_addCentre')]
    public function addCentre(ManagerRegistry $doctrine,Request $request,CentreRepository $repository)
    {
        $c= $repository->findAll();
        $Centre= new Centre();
        $form=$this->createForm(CentreFormType::class,$Centre);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $file = $form['Logo']->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );
            $Centre->setLogo($fileName);
            $em =$doctrine->getManager() ;
            $em->persist($Centre);
            $em->flush();
            return $this->redirectToRoute("app_addCentre");
        }
        else {
            // Form is not valid, retrieve the errors
            $errors = $form->getErrors();
        }
       
        return $this->render("centre/addCentre.html.twig", [
        'formClass' => $form->createView(),
        "Centre"=>$c,
        
    ]);
     }
}
