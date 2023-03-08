<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;


class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/addUser.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/suppUser/{id}', name: 'supprimerU')]

    public function suppU(ManagerRegistry $doctrine,$id,UserRepository $repository)
      {
      //récupérer le User à supprimer
          $User= $repository->find($id);
      //récupérer l'entity manager
          $em= $doctrine->getManager();
          $em->remove($User);
          $em->flush();
          return $this->redirectToRoute("app_addUser");///////////////////////
      } 

      #[Route('/updatUser/{id}', name: 'updatU')]

    public function updatU(ManagerRegistry $doctrine,$id,UserRepository $repository,Request $request)
      {
      //récupérer le User à supprimer
      
          $c= $repository->findAll();
          $User= $repository->find($id);
          $newUser= new User();
          $form=$this->createForm(UserFormType::class,$newUser);
          $form->get('email')->setData($User->getEmail());
          $form->get('roles')->setData($User->getRoles());
          //$form->get('password')->setData($User->getPassword());
          $form->get('nom')->setData($User->getNom());
          $form->get('prenom')->setData($User->getPrenom());
          $form->get('num_tel')->setData($User->getNumTel());
          $form->get('ville')->setData($User->getVille());
          $form->get('date_naissance')->setData($User->getDateNaissance());
          
          
         
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $file = $form['image']->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );
            $newUser->setImage($fileName);
            $em =$doctrine->getManager() ;
            $User->setEmail($newUser->getEmail());
            $User->setRoles($newUser->getRoles());
           // $User->setPassword($newUser->getPassword());
            $User->setNom($newUser->getNom());
            $User->setPrenom($newUser->getPrenom());
            $User->setNumTel($newUser->getNumTel());
            $User->setVille($newUser->getVille());
            $User->setDateNaissance($newUser->getDateNaissance());
            $User->setImage($newUser->getImage());
            $em->flush();
            return $this->redirectToRoute("app_addUser");
        }
        else {
            // Form is not valid, retrieve the errors
            $errors = $form->getErrors(true, false);

            // Display the errors
            
        }
        return $this->render("user/updateUser.html.twig", [
            'formClass' => $form->createView(),
            "User"=>$c,
        ]);
      } 

      /*#[Route('/updatUser/{id}', name: 'updatP')]

    public function updatP(ManagerRegistry $doctrine,$id,UserRepository $repository,Request $request)
      {
      //récupérer le User à supprimer
          $User= $repository->find($id);
          $newUser= new User();
          $form=$this->createForm(UserFormType::class,$newUser);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em =$doctrine->getManager() ;
            $User->setLibelle($newUser->getLibelle());
            $User->setDescription($newUser->getDescription());
            $User->setImage($newUser->getImage());
            $em->flush();
            return $this->redirectToRoute("afficheP");
        }
        return $this->renderForm("User/updateUser.html.twig",/////////////////////////////////////////////
        array("formClass"=>$form));//////////////////////////
      } */

      #[Route('/afficheUser', name: 'afficheU')]

      public function showU(UserRepository $repository)
      {
          $c= $repository->findAll();
          return $this->render("User/showUser.html.twig",
          ["User"=>$c]);
        }


        

         
             

 #[Route('/addUser', name: 'app_addUser')]
    public function addUser(ManagerRegistry $doctrine,Request $request,UserRepository $repository)
    {
        $c= $repository->findAll();
        $User= new User();
        $form=$this->createForm(UserFormType::class,$User);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $file = $form['image']->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );
            $User->setImage($fileName);
            $em =$doctrine->getManager() ;
            $em->persist($User);
            $em->flush();
            return $this->redirectToRoute("app_addUser");
        }
        else {
            // Form is not valid, retrieve the errors
            $errors = $form->getErrors();
        }
       
        return $this->render("user/addUser.html.twig", [
        'formClass' => $form->createView(),
        "User"=>$c,
        
    ]);
     }
}
