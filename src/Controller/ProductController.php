<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Form\ProductFormType;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use App\Repository\FavoriteRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\File;
use TCPDF;
use Symfony\Component\HttpFoundation\BinaryFileResponse;




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

    public function updatP(ManagerRegistry $doctrine,$id,ProductRepository $repository,Request $request, PaginatorInterface $paginator,MailerInterface $mailer,UserRepository $userRepo,FavoriteRepository $favRepo)
      {
      //récupérer le Product à supprimer
      
          $cc= $repository->findAll();
          $c = $paginator->paginate(
            $cc, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            4 // Nombre de résultats par page
        );
          $Product= $repository->find($id);
          $favorits = $favRepo->findBy(['product' => $Product]);
          foreach($favorits as $fav)
          {
            $Emails[]=$fav->getUser()->getEmail();
                
            
            //dd($fav->getUser()->getEmail());
          }
          //dd(!empty($Emails));
          
          $oldQuentte=$Product->getQuantite();
          $newProduct= new Product();
          $form=$this->createForm(ProductFormType::class,$newProduct);
          $form->get('libelle')->setData($Product->getLibelle());
          $form->get('description')->setData($Product->getDescription());
          $form->get('quantite')->setData($Product->getQuantite());
          
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
            $Product->setQuantite($newProduct->getQuantite());
            $Product->setImage($newProduct->getImage());
            $em->flush();
            $this->addFlash('success', 'Produit modifier avec succée!');
            if(!empty($Emails))
            {
            if($Product->getQuantite()>0 && $oldQuentte==0)
            {
                foreach($Emails as $emaile)
                {
                $email = (new Email())
                    ->from('commercial.edusex@gmail.com')
                    ->to($emaile)
                    ->subject('Your Product Is Available Now !')
                    ->text('Sending emails is fun again!')
                    ->html('<h2>the product in your favorit list is back again!</h2>')
                    
                    ;
        
                $mailer->send($email);
                }
            }
        }
            return $this->redirectToRoute("app_addProduct");
        }
        else {
            // Form is not valid, retrieve the errors
            $errors = $form->getErrors(true, false);

            // Display the errors
            
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

      public function showP(ProductRepository $repository, PaginatorInterface $paginator,Request $request)
      {
        $cc= $repository->findAll();
        $c = $paginator->paginate(
          $cc, // Requête contenant les données à paginer (ici nos articles)
          $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
          3 // Nombre de résultats par page
      );
          return $this->render("Product/showProduct.html.twig",
          ["Product"=>$c,"Products"=>$cc]);
        }

        #[Route('/afficheDetailsProduct/{id}', name: 'afficheDetailsP')]

      public function showDetailsP(ProductRepository $repository,$id)
      {
          $c= $repository->find($id);
          if($c->getQuantite()==0)
          $this->addFlash('warning', 'ce produit est hors stock pour le moment !');
          return $this->render("Product/showDetailsProduct.html.twig",
          ["Product"=>$c]);
        }



        

         
             

 #[Route('/addProduct', name: 'app_addProduct')]
    public function addProduct(ManagerRegistry $doctrine,Request $request,ProductRepository $repository, PaginatorInterface $paginator,MailerInterface $mailer)
    {
        if($request->query->get('query')== NULL)
        {
        $cc= $repository->findAll();
          $c = $paginator->paginate(
            $cc, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            4 // Nombre de résultats par page
        );
        }
        else{
            $query = $request->query->get('query');
            $cc= $repository->searchByLibelleAndDescription($query);
          $c = $paginator->paginate(
            $cc, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3 // Nombre de résultats par page
        );
        }
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
            $this->addFlash('success', 'Produit crée avec succée !');
            $email = (new Email())
                    ->from('commercial.edusex@gmail.com')
                    ->to('baklouti.wassim@esprit.tn')
                    ->subject('A New Product Is Available Now !')
                    ->text('Sending emails is fun again!')
                    ->html('<p>A New Product Is Available Now !</p>')
                    
                    ;
        
                $mailer->send($email);
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



     #[Route('/addProductJSON', name: 'app_addProductJSON')]
    public function addProductJSON(ManagerRegistry $doctrine,Request $request,SerializerInterface $serializer)
    {
        
        $Product= new Product();
        $Product->setLibelle($request->get("libelle"));
        $Product->setDescription($request->get("description"));
        $Product->setQuantite($request->get("quantite"));
        $imagePath = urldecode($_GET['image']);
        $fileName = md5(uniqid()).'.'.pathinfo($imagePath, PATHINFO_EXTENSION);
        copy($imagePath, $this->getParameter('images_directory') . '/' . $fileName);
        $Product->setImage($fileName);
        $em =$doctrine->getManager() ;
        $em->persist($Product);
        $em->flush();
        $jason = $serializer->serialize($Product,'json',['groups'=>'product_list']);
        return new Response($jason);
     }//http://127.0.0.1:8000/addProductJSON?libelle=mahmoud&description=miboun&image=C:%2FUsers%2FLENOVO%2FDownloads%2Fwassim.jpg&quantite=21

     #[Route('/showProductJSON', name: 'app_showProductJSON')]
    public function showProductJSON(ProductRepository $repository,Request $request,SerializerInterface $serializer)
    {
        $cc= $repository->findAll();  
        $data = [];

        foreach ($cc as $c) {
            
            $data[] = [
                'id' => $c->getId(),
                'quantite' => $c->getQuantite(),
                'libelle' => $c->getLibelle(),
                'description' => $c->getDescription(),
                'image' => $c->getImage(),
            ];
        }   
        $jason = $serializer->serialize($data,'json',['groups'=>'product_list']);
        return new Response($jason);
     }

     #[Route('/image/{image}', name: 'image')]
     public function getPicture(Request $request): BinaryFileResponse
    {
        return new BinaryFileResponse(
            $this->getParameter('images_directory') . "/" . $request->get("image")
        );
    }


     #[Route('/updateProductJSON/{id}', name: 'app_updateProductJSON')]
    public function updateProductJSON(ProductRepository $repository,ManagerRegistry $doctrine,Request $request,SerializerInterface $serializer,$id)
    {


        $Product= new Product();
        $Product= $repository->find($id);
        $Product->setLibelle($request->get("libelle"));
        $Product->setDescription($request->get("description"));
        $Product->setQuantite($request->get("quantite"));
        $imagePath = urldecode($_GET['image']);
        $fileName = md5(uniqid()).'.'.pathinfo($imagePath, PATHINFO_EXTENSION);
        copy($imagePath, $this->getParameter('images_directory') . '/' . $fileName);
        $Product->setImage($fileName);
        //$Reservations->addIdProduit($request->get("idProduit"));
        $em =$doctrine->getManager() ;
        //$em->persist($Reservations);
        $em->flush();
        $data = $serializer->serialize($Product,'json',['groups'=>'product_list']);
        return new Response($data);
     }//http://127.0.0.1:8000/updateProductJSON?libelle=mahmoud&description=miboun&image=C:%2FUsers%2FLENOVO%2FDownloads%2Fwassim.jpg&quantite=21


    //  #[Route("email", name: "app_mail")]

    //  public function sendEmail(MailerInterface $mailer)
    //  {
    //      $email = (new Email())
    //          ->from('commercial.edusex@gmail.com')
    //          ->to('baklouti.wassim@esprit.tn')
    //          ->subject('Hello from Symfony Mailer!')
    //          ->text('Sending emails is fun again!')
    //          ->html('<p>Ya3tek 3asba <em>fun</em> again!</p>');
     
    //      $mailer->send($email);
     
    //      return new Response("Success");
    //  }
    public function searchAction(Request $request,ProductRepository $repository)
    {
        $libelle = $request->get('libelle');
    
        $produits = $repository->createQueryBuilder('p')
            ->where('p.libelle LIKE :libelle')
            ->setParameter('libelle', '%' . $libelle . '%')
            ->getQuery()
            ->getResult();
    
        $response = new JsonResponse();
        $response->setData(array(
            'produits' => $produits,
        ));
    
        return $response;
    }
//     #[Route('/search', name: 'search')]
//     public function searchProducts(Request $request,ProductRepository $repository)
// {
//     $query = $request->query->get('query');
//     dd($query);
//     $products = $repository->searchByLibelleAndDescription($query);
//     dd($products);
    
//     return new JsonResponse($products);
// }

#[Route('/pdfProduct', name: 'app_pdfProduct')]
     public function exportPdf(ProductRepository $repositoryR)
    {
        $c= $repositoryR->findAll();
        // create new TCPDF object
        $pdf = new TCPDF();

        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('John Doe');
        $pdf->SetTitle('My PDF Document');
        $pdf->SetSubject('Document subject');
        $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

        // set default font subsetting mode
        $pdf->setFontSubsetting(true);

        // set margins
        $pdf->SetMargins(10, 10, 10);

        // set auto page breaks
        $pdf->SetAutoPageBreak(true, 10);

        // add a page
        $pdf->AddPage();

        // render Twig template to HTML
        $html = $this->renderView('PDF/listProductPDF.html.twig', [
            "Product"=>$c
        ]);

        // set content
        $pdf->writeHTML($html, true, false, true, false, '');

        // output PDF
        $pdf->Output('example.pdf', 'D');

        // return response
        return new Response('PDF exported successfully!');
    }

    #[Route('/search', name: 'search', methods: ['GET'])]
    public function search(Request $request , ProductRepository $cr ,SerializerInterface $serializer): JsonResponse
    {
        $query = $request->get('q');
        $sort = $request->get('sort', 'name'); // Default to sorting by id if no sort parameter is provided
    

        // Effectuer la recherche dans votre base de données ou ailleurs
        $resultss = $cr->searchByLibelleAndDescription($query);
        // Retourner les résultats au format JSON
        
        $json=$serializer->serialize($resultss,'json',['groups'=>'club']);
       
        return $this->json([
            'resultss' => $this->renderView('product/search.html.twig', [
                'Product' => $json,
               
                
            ]),
        
           
        ]);
    }
     
}
