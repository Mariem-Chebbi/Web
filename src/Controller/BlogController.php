<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Blog;
use App\Form\BlogFormType;
use App\Repository\BlogRepository;
use Doctrine\Persistence\ManagerRegistry;


class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(): Response
    {
        return $this->render('blog/addBlog.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    #[Route('/suppBlog/{id}', name: 'supprimerB')]

    public function suppP(ManagerRegistry $doctrine,$id,BlogRepository $repository)
      {
      //récupérer le Blog à supprimer
          $Blog= $repository->find($id);
      //récupérer l'entity manager
          $em= $doctrine->getManager();
          $em->remove($Blog);
          $em->flush();
          return $this->redirectToRoute("app_addBlog");///////////////////////
      } 

      #[Route('/updatBlog/{id}', name: 'updatB')]

    public function updatP(ManagerRegistry $doctrine,$id,BlogRepository $repository,Request $request)
      {
      //récupérer le Blog à supprimer
      
          $c= $repository->findAll();
          $Blog= $repository->find($id);
          $newBlog= new Blog();
          $form=$this->createForm(BlogFormType::class,$newBlog);
          $form->get('libelle')->setData($Blog->getLibelle());
          $form->get('description')->setData($Blog->getDescription());
          $form->get('date')->setData($Blog->getDate());
          $form->get('auteur')->setData($Blog->getAuteur());
         
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $file = $form['image']->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );
            $newBlog->setImage($fileName);
            $em =$doctrine->getManager() ;
            $Blog->setLibelle($newBlog->getLibelle());
            $Blog->setDescription($newBlog->getDescription());
            $Blog->setDate($newBlog->getDate());
            $Blog->setAuteur($newBlog->getAuteur());
            $Blog->setImage($newBlog->getImage());
            $em->flush();
            return $this->redirectToRoute("app_addBlog");
        }
        else {
            // Form is not valid, retrieve the errors
            $errors = $form->getErrors(true, false);

            // Display the errors
            foreach ($errors as $error) {
                $message = $error->getMessage();
            }
        }
        return $this->render("blog/addBlog.html.twig", [
            'formClass' => $form->createView(),
            "Blog"=>$c,
        ]);
      } 

    

      #[Route('/afficheBlog', name: 'afficheBlog')]

      public function showP(BlogRepository $repository)
      {
          $c= $repository->findAll();
          return $this->render("Blog/showBlog.html.twig",
          ["Blog"=>$c]);
        }


        

         
             

 #[Route('/addBlog', name: 'app_addBlog')]
    public function addBlog(ManagerRegistry $doctrine,Request $request,BlogRepository $repository)
    {
        $c= $repository->findAll();
        $Blog= new Blog();
        $form=$this->createForm(BlogFormType::class,$Blog);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $file = $form['image']->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );
            $Blog->setImage($fileName);
            $em =$doctrine->getManager() ;
            $em->persist($Blog);
            $em->flush();
            return $this->redirectToRoute("app_addBlog");
        }
        else {
            // Form is not valid, retrieve the errors
            $errors = $form->getErrors();
        }
       
        return $this->render("blog/addBlog.html.twig", [
        'formClass' => $form->createView(),
        "Blog"=>$c,
        
    ]);
     }
}
