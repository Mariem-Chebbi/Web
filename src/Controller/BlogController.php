<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Blog;
use App\Form\BlogFormType;
use App\Repository\BlogRepository;
use App\Repository\CommentBlogRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use TCPDF;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

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

    public function updatP(ManagerRegistry $doctrine,$id,BlogRepository $repository,Request $request, PaginatorInterface $paginator)
      {
      //récupérer le Blog à supprimer
      
      $cc= $repository->findAll();
      $c = $paginator->paginate(
        $cc, // Requête contenant les données à paginer (ici nos articles)
        $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
        3 // Nombre de résultats par page
    );
          $Blog= $repository->find($id);
          $newBlog= new Blog();
          $form=$this->createForm(BlogFormType::class,$newBlog);
          $form->get('libelle')->setData($Blog->getLibelle());
          $form->get('description')->setData($Blog->getDescription());
          $form->get('date')->setData($Blog->getDate());
          $form->get('auteur')->setData($Blog->getAuteur());
          $form->get('Categorie')->setData($Blog->getCategorie());
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
            //$Blog->setIdCategorie($newBlog->getIdCategorie());
            $Blog->setImage($newBlog->getImage());
            $em->flush();
            $this->addFlash('success', 'blog modifier avec succée!');
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

        #[Route('/afficheDetailsBlog/{id}', name: 'afficheDetailsB')]

        public function showDetailsB(CommentBlogRepository $commentRepository,BlogRepository $repository,$id)
        {
            $c= $repository->find($id);
            $comments = $commentRepository->findBy(['blog' => $id]);
            foreach($comments as $comment)
            {
                $Comment[]=[
                    'comment'=>$comment->getComment(),
                    'userName'=>$comment->getUser()->getNom()
                ];
           
            }
        
            if(!empty($Comment))
            {
                return $this->render('Blog/showDetalsBlogComent.html.twig', [
                        "Comment" => $Comment,
                        "Blog"=>$c
                    ]);
            }
            else     
                return $this->render("Blog/showDetalsBlog.html.twig",
                        ["Blog"=>$c]);
            
        }
        

         
             

 #[Route('/addBlog', name: 'app_addBlog')]
    public function addBlog(ManagerRegistry $doctrine,Request $request,BlogRepository $repository, PaginatorInterface $paginator,MailerInterface $mailer)
    {
        if($request->query->get('query')== NULL)
        {
        $cc= $repository->findAll();
          $c = $paginator->paginate(
            $cc, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3 // Nombre de résultats par page
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
            $this->addFlash('success', 'blog cree avec succée!');
            $email = (new Email())
                    ->from('commercial.edusex@gmail.com')
                    ->to('baklouti.wassim@esprit.tn')
                    ->subject('A New Blog Is Available Now !')
                    ->text('Sending emails is fun again!')
                    ->html('<p>A New Blog Is Available Now!</p>')
                    
                    ;
        
                $mailer->send($email);
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

     #[Route('/pdfBlog/{id}', name: 'app_pdfBlog')]
     public function exportPdf(BlogRepository $repositoryR,$id)
    {
        $c= $repositoryR->find($id);
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

        // $image_file = $c->getImage();
        // $pdf->Image($image_file, 10, 10, 50, 50, 'JPG');

        // render Twig template to HTML
        $html = $this->renderView('PDF/showDetailsBlogPDF.html.twig', [
            "Blog"=>$c
        ]);

        // set content
        $pdf->writeHTML($html, true, false, true, false, '');

        // output PDF
        $pdf->Output('example.pdf', 'D');

        // return response
        return new Response('PDF exported successfully!');
    }
    #[Route('/showBlogJSON', name: 'app_showBlogJSON')]
    public function showBlogsJSON(BlogRepository $repository,Request $request,NormalizerInterface $normalizer)
    {
        $cc= $repository->findAll(); 
        $data = [];

        foreach ($cc as $c) {
            $idCategorie = [];

            
                foreach ($c->getCategorie() as $Categorie)
                $idCategorie[] = [
                    'categorie' => $Categorie->getId(),
                ];
            

            $data[] = [
                'id' => $c->getId(),
                'libelle' => $c->getLibelle(),
                'description' => $c->getDescription(),
                'image' => $c->getImage(),               
                'auteur' => $c->getAuteur(),
                'date' => $c->getDate(), 
                'Categorie' => $Categorie->getLibelle(),
            ];
        }
        
            $normalized = $normalizer->normalize($data,'json',['groups'=>'Blog_list']);
            //$jason = json_encode($normalized);
        
            
         $jason = json_encode($normalized);
        return new Response($jason);
     }
     #[Route('/image/{image}', name: 'image')]
     public function getPicture(Request $request): BinaryFileResponse
    {
        //test git
        return new BinaryFileResponse(
            $this->getParameter('images_directory') . "/" . $request->get("image")
        );
    }
}

