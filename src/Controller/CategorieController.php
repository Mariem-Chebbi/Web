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
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


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

    public function updatC(ManagerRegistry $doctrine,$id,CategorieRepository $repository,Request $request, PaginatorInterface $paginator)
      {
      //récupérer le Categorie à supprimer
      
      $cc= $repository->findAll();
      $c = $paginator->paginate(
        $cc, // Requête contenant les données à paginer (ici nos articles)
        $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
        3 // Nombre de résultats par page
    );
          $Categorie= $repository->find($id);
          $newCategorie= new Categorie();
          $form=$this->createForm(CategorieFormType::class,$newCategorie);
          $form->get('Libelle')->setData($Categorie->getLibelle());
         
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            
            $em =$doctrine->getManager() ;
            $Categorie->setLibelle($newCategorie->getLibelle());
            $em->flush();
            $this->addFlash('success', 'categorie modifier avec succée!');
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
    public function addCategorie(ManagerRegistry $doctrine,Request $request,CategorieRepository $repository, PaginatorInterface $paginator)
    {
        $cc= $repository->findAll();
      $c = $paginator->paginate(
        $cc, // Requête contenant les données à paginer (ici nos articles)
        $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
        3 // Nombre de résultats par page
    );
        $Categorie= new Categorie();
        $form=$this->createForm(CategorieFormType::class,$Categorie);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            
            $em =$doctrine->getManager() ;
            $em->persist($Categorie);
            $em->flush();
            $this->addFlash('success', 'categorie cree avec succée!');
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
     #[Route('/showCategorieJSON', name: 'app_showCategorieJSON')]
     public function showCategoriesJSON(CategorieRepository $repository,Request $request,NormalizerInterface $normalizer)
     {
         $cc= $repository->findAll(); 
         $data = [];
 
         
             
 
            foreach ($cc as $c) {
                $blogs = [];
    
                
                    foreach ($c->getBlog() as $Blog)
                    $blogs[] = [
                        'Blog' => $Blog->getId(),
                        'libelleBlog' => $Blog->getLibelle(),
                        'descriptionBlog' => $Blog->getDescription(),
                        'dateBlog' => $Blog->getDate(),
                        'AuteurBlog' => $Blog->getAuteur(),
                        'imageBlog' => $Blog->getImage(),


                    ];
                
             
 
             $data[] = [
                 'id' => $c->getId(),
                 'libelle' => $c->getLibelle(),
                 'Blog' => $blogs,
                 //'Blog' => $Blogs->getLibelle(),

                
             ];
         }
         
             $normalized = [$normalizer->normalize($data,'json',['groups'=>'Categorie_list'])];
             //$jason = json_encode($normalized);
         
             
          $jason = json_encode($normalized);
         return new Response($jason);
      }
}
