<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Formation;
use App\Form\FormationFormType;
use App\Repository\FormationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Gregwar\CaptchaBundle\Type\CaptchaType;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use TCPDF;

use Endroid\QrCode\QrCode;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Endroid\QrCode\Writer\PngWriter;




class FormationController extends AbstractController
{
    #[Route('/formation', name: 'app_formation')]
    public function index(): Response
    {
        return $this->render('formation/addFormation.html.twig', [
            'controller_name' => 'FormationController',
        ]);
    }

    #[Route('/suppFormation/{id}', name: 'supprimerF')]

    public function suppC(ManagerRegistry $doctrine,$id,FormationRepository $repository)
      {
      //récupérer le Formation à supprimer
          $Formation= $repository->find($id);
      //récupérer l'entity manager
          $em= $doctrine->getManager();
          $em->remove($Formation);
          $em->flush();
          return $this->redirectToRoute("app_addFormation");///////////////////////
      } 

      #[Route('/updatFormation/{id}', name: 'updatF')]

    public function updatC(PaginatorInterface $paginator,ManagerRegistry $doctrine,$id,FormationRepository $repository,Request $request)
      {
      //récupérer le Formation à supprimer
      
      $c= $repository->findAll();
      $cc= $paginator->paginate(
          $c, // Requête contenant les données à paginer (ici nos articles)
          $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
          5 // Nombre de résultats par page
      );
          $Formation= $repository->find($id);
          $newFormation= new Formation();
          $form=$this->createForm(FormationFormType::class,$newFormation);
          $form->get('libelle')->setData($Formation->getLibelle());
          $form->get('description')->setData($Formation->getDescription());
          $form->get('dateFormation')->setData($Formation->getDateFormation());
          //$form->get('description')->setData($Formation->getDescription());
         
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $file = $form['image']->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );
            $newFormation->setImage($fileName);
            $em =$doctrine->getManager() ;
            $Formation->setLibelle($newFormation->getLibelle());
            $Formation->setDescription($newFormation->getDescription());
            $Formation->setImage($newFormation->getImage());
            $Formation->setDateFormation($newFormation->getDateFormation());
            $em->flush();
            $this->addFlash('success','Formation modifié avec succès !');
            return $this->redirectToRoute("app_addFormation");
        }
        else {
            // Form is not valid, retrieve the errors
            $errors = $form->getErrors(true, false);

            // Display the errors
            
        }
        return $this->render("Formation/addFormation.html.twig", [
            'formClass' => $form->createView(),
            "Formation"=>$cc,
        ]);
      } 

      /*#[Route('/updatFormation/{id}', name: 'updatP')]

    public function updatP(ManagerRegistry $doctrine,$id,FormationRepository $repository,Request $request)
      {
      //récupérer le Formation à supprimer
          $Formation= $repository->find($id);
          $newFormation= new Formation();
          $form=$this->createForm(FormationFormType::class,$newFormation);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em =$doctrine->getManager() ;
            $Formation->setLibelle($newFormation->getLibelle());
            $Formation->setDescription($newFormation->getDescription());
            $Formation->setImage($newFormation->getImage());
            $em->flush();
            return $this->redirectToRoute("afficheP");
        }
        return $this->renderForm("Formation/updateFormation.html.twig",/////////////////////////////////////////////
        array("formClass"=>$form));//////////////////////////
      } */

      #[Route('/afficheFormation', name: 'afficheC')]

      public function showC(ManagerRegistry $doctrine,PaginatorInterface $paginator,FormationRepository $repository,Request $request)
      {
       // if ($request->isXmlHttpRequest()) { // Vérifier si la requête est AJAX
            
                        // $term = $request->query->get('term');
                        //     $cc = $doctrine
                        //         ->getRepository(Formation::class)
                        //         ->searchByLibelleAndDescription($term); // Appeler la méthode personnalisée searchByLibelleAndDescription() du Repository

                        //     return $this->render("Formation/showFormation.html.twig", [
                        //         "Formation" => $cc,
                        //     ]);
       // }//return new JsonResponse(['message' => 'This is not an AJAX request.'], 400);
        
        $c= $repository->findAll();
        $cc= $paginator->paginate(
            $c, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            5 // Nombre de résultats par page
        );          
          return $this->render("Formation/showFormation.html.twig",
          ["Formation"=>$cc]);
        }

 #[Route('/addFormation', name: 'app_addFormation')]
    public function addFormation(PaginatorInterface $paginator, ManagerRegistry $doctrine,Request $request,FormationRepository $repository,MailerInterface $mailer)
    {

        $c= $repository->findAll();
        $cc= $paginator->paginate(
            $c, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3 // Nombre de résultats par page
        );
        $Formation= new Formation();
        $form=$this->createForm(FormationFormType::class,$Formation);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $file = $form['image']->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );
            $Formation->setImage($fileName);
            $em =$doctrine->getManager() ;
            $em->persist($Formation);
            $em->flush();
            
            $this->addFlash('success','Formation crée avec succès !');
            $email = (new Email())
             ->from('commercial.edusex@gmail.com')
             ->to('abir.zahra@esprit.tn')
             ->subject('Hello from Symfony Mailer!')
             ->text('Sending emails is fun again!')
             ->html('<p>test <em>fun</em> again!</p>');
     
         $mailer->send($email);
            return $this->redirectToRoute("app_addFormation");
        }
        else {
            // Form is not valid, retrieve the errors
            $errors = $form->getErrors();
        }
       
        return $this->render("Formation/addFormation.html.twig", [
        'formClass' => $form->createView(),
        "Formation"=>$cc,
        
    ]);
    }

    #[Route('/afficheDetailsFormation/{id}', name: 'afficheDetailsF')]
      public function showDetailsF(FormationRepository $repository,$id)
      {
          $c= $repository->find($id);
          return $this->render("Formation/showDetailsFormation.html.twig",
          ["Formation"=>$c]);
        }



        #[Route('/addFormationJSON', name: 'app_addFormationJSON')]
    public function addFormationJSON(ManagerRegistry $doctrine,Request $request,SerializerInterface $serializer)
    {        
        $Formation= new Formation();
        $Formation->setLibelle($request->get("libelle"));
        $Formation->setDescription($request->get("description"));       
        $dateFormation = new \DateTime($request->get("dateFormation"));
        $Formation->setDateFormation($dateFormation);
        //$Formation->setIdCertif($request->get("idCertif"));
        //$Formation->setInscriptions($request->get("inscriptions"));
        $imagePath = urldecode($_GET['image']);
        $fileName = md5(uniqid()).'.'.pathinfo($imagePath, PATHINFO_EXTENSION);
        copy($imagePath, $this->getParameter('images_directory') . '/' . $fileName);
        $Formation->setImage($fileName);
        $em =$doctrine->getManager() ;
        $em->persist($Formation);
        $em->flush();
        $jason = $serializer->serialize($Formation,'json',['groups'=>'Formation_list']);
        return new Response($jason);
     }
//http://127.0.0.1:8000/addFormationJSON?libelle=abir&description=test&dateFormation=2025-01-01T01:01:00Z&image=C:%2FUsers%2FASUS%2FDownloads%2F_MG_4193.jpg
     

#[Route('/showFormationJSON', name: 'app_showFormationJSON')]
    public function showFormationJSON(FormationRepository $repository,Request $request,SerializerInterface $serializer)
    {
        $cc= $repository->findAll();  
        $data = [];       
        foreach ($cc as $c) {        
            $data[] = [
                'id' => $c->getId(),
                'libelle' => $c->getLibelle(),
                'description' => $c->getDescription(),
                'image' => $c->getImage(),               
                'dateFormation' => $c->getDateFormation(),              
                //'idCertif' => $c->getIdCertif(),
                //'inscriptions' => $c->getInscriptions(),
            ];
        }   
        $jason = $serializer->serialize($data,'json',['groups'=>'Formation_list']);
        return new Response($jason);
     }


     #[Route('/updateFormationJSON/{id}', name: 'app_updateFormationJSON')]
    public function updateFormationJSON(FormationRepository $repository,ManagerRegistry $doctrine,Request $request,SerializerInterface $serializer,$id)
    {
        $Formation= new Formation();
        $Formation= $repository->find($id);
        $Formation->setLibelle($request->get("libelle"));
        $Formation->setDescription($request->get("description"));
        
        $dateFormation = new \DateTime($request->get("dateFormation"));
        $Formation->setDateFormation($dateFormation);
        // $Formation->setIdCertif($request->get("idCertif"));
        // $Formation->setInscriptions($request->get("inscriptions"));
        
        $imagePath = urldecode($_GET['image']);
        $fileName = md5(uniqid()).'.'.pathinfo($imagePath, PATHINFO_EXTENSION);
        copy($imagePath, $this->getParameter('images_directory') . '/' . $fileName);
        $Formation->setImage($fileName);
        //$Reservations->addIdProduit($request->get("idProduit"));
        $em =$doctrine->getManager() ;
        //$em->persist($Reservations);
        $em->flush();
        $data = $serializer->serialize($Formation,'json',['groups'=>'Formation_list']);
        return new Response($data);
     }
    //http://127.0.0.1:8000/updateFormationJSON/31?libelle=abirabirabir&description=test&dateFormation=2025-01-01T01:01:00Z&image=C:%2FUsers%2FASUS%2FDownloads%2F_MG_4193.jpg


    //  #[Route('/email', name: 'app_mail')]

    //  public function sendEmail(MailerInterface $mailer)
    //  {
    //      $email = (new Email())
    //          ->from('commercial.edusex@gmail.com')
    //          ->to('abir.zahra@esprit.tn')
    //          ->subject('Hello from Symfony Mailer!')
    //          ->text('Sending emails is fun again!')
    //          ->html('<p>test <em>fun</em> again!</p>');
     
    //      $mailer->send($email);
     
    //      return new Response("Success");
    //  }

    #[Route('/pdfFormation', name: 'app_pdfFormation')]
     public function exportPdf(FormationRepository $repositoryR)
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
        $html = $this->renderView('PDF/listFormationPDF.html.twig', [
            "Formation"=>$c
        ]);

        // set content
        $pdf->writeHTML($html, true, false, true, false, '');

        // output PDF
        $pdf->Output('example.pdf', 'D');

        // return response
        return new Response('PDF exported successfully!');
    }


//     #[Route('/qrFormation', name: 'app_qrFormation')]
//     public function generateQrCodeAction()
// {
// //     $url = $this->generateUrl('afficheDetailsF', array('id' => $formationId), UrlGeneratorInterface::ABSOLUTE_URL);
// //     $pngWriter = new PngWriter();
// //     $qrCode = new QrCode($url);
// // //dd($url);
// //     //header('Content-Type: '.$qrCode->getContentType());
// //     echo $qrCode->writeString();
// //     exit;

// $qrCode = new QrCode('Hello world');

// // Génération de l'image PNG
// $pngDataUri = $qrCode->writeDataUri('image/png');

// // Affichage de l'image PNG
// echo '<img src="'.$pngDataUri.'">';
//             exit;

// }
}
