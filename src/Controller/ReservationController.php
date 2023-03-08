<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reservation;
use App\Form\ReservationFormType;
use App\Repository\ReservationRepository;
use Doctrine\Persistence\ManagerRegistry;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation')]
    public function index(): Response
    {
        return $this->render('reservation/addReservation.html.twig', [
            'controller_name' => 'ReservationController',
        ]);
    }

    #[Route('/suppReservation/{id}', name: 'supprimerR')]

    public function suppP(ManagerRegistry $doctrine,$id,ReservationRepository $repository)
      {
      //récupérer le Reservation à supprimer
          $Reservation= $repository->find($id);
      //récupérer l'entity manager
          $em= $doctrine->getManager();
          $em->remove($Reservation);
          $em->flush();
          return $this->redirectToRoute("app_addReservation");///////////////////////
      } 

      #[Route('/updatReservation/{id}', name: 'updatR')]

    public function updatR(ManagerRegistry $doctrine,$id,ReservationRepository $repository,Request $request)
      {
      //récupérer le Reservation à supprimer
      
          $c= $repository->findAll();
          $Reservation= $repository->find($id);
          $newReservation= new Reservation();
          $form=$this->createForm(ReservationFormType::class,$newReservation);
          $form->get('idProduit')->setData($Reservation->getIdProduit());
          $form->get('quantite')->setData($Reservation->getQuantite());
          $form->get('dateReservation')->setData($Reservation->getDateReservation());
          $form->get('etat')->setData($Reservation->getEtat());
         
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            
            $em =$doctrine->getManager() ;
            $Reservation->setQuantite($newReservation->getQuantite());
            $Reservation->setDateReservation($newReservation->getDateReservation());
            $Reservation->setEtat($newReservation->getEtat());
            $em->flush();
            return $this->redirectToRoute("app_addReservation");
        }
        else {
            // Form is not valid, retrieve the errors
            $errors = $form->getErrors();
        }
        return $this->render("reservation/traiter_reservation.html.twig", [
            'formClass' => $form->createView(),
            "Reservation"=>$c,
        ]);
      } 

      /*#[Route('/updatReservation/{id}', name: 'updatP')]

    public function updatP(ManagerRegistry $doctrine,$id,ReservationRepository $repository,Request $request)
      {
      //récupérer le Reservation à supprimer
          $Reservation= $repository->find($id);
          $newReservation= new Reservation();
          $form=$this->createForm(ReservationFormType::class,$newReservation);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em =$doctrine->getManager() ;
            $Reservation->setLibelle($newReservation->getLibelle());
            $Reservation->setDescription($newReservation->getDescription());
            $Reservation->setImage($newReservation->getImage());
            $em->flush();
            return $this->redirectToRoute("afficheP");
        }
        return $this->renderForm("Reservation/updateReservation.html.twig",/////////////////////////////////////////////
        array("formClass"=>$form));//////////////////////////
      } */

      #[Route('/afficheReservation', name: 'afficheR')]

      public function showR(ReservationRepository $repository)
      {
          $c= $repository->findAll();
          return $this->render("Reservation/showReservation.html.twig",
          ["Reservation"=>$c]);
        }


        

         
             

 #[Route('/addReservation', name: 'app_addReservation')]
    public function addReservation(ManagerRegistry $doctrine,Request $request,ReservationRepository $repository)
    {
        $c= $repository->findAll();
        $Reservation= new Reservation();
        $form=$this->createForm(ReservationFormType::class,$Reservation);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            
            
            $em =$doctrine->getManager() ;
            $em->persist($Reservation);
            $em->flush();
            return $this->redirectToRoute("app_addReservation");
        }
        else {
            // Form is not valid, retrieve the errors
            $errors = $form->getErrors();
        }
       
        return $this->render("reservation/reservation_back.html.twig", [
        'formClass' => $form->createView(),
        "Reservation"=>$c,
        
    ]);
     }
}
