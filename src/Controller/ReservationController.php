<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Reservation;
use App\Form\ReservationFormType;
use App\Form\ReservationFrontFormType;
use App\Entity\Product;
use App\Repository\ReservationRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use DateTime;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Snappy\Pdf;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use TCPDF;
use Symfony\Component\Mime\Part\HtmlPart;

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

    public function updatR(ManagerRegistry $doctrine,$id,ReservationRepository $repository,Request $request, PaginatorInterface $paginator)
      {
      //récupérer le Reservation à supprimer
      
      $cc= $repository->findAll();
      $c = $paginator->paginate(
        $cc, // Requête contenant les données à paginer (ici nos articles)
        $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
        4 // Nombre de résultats par page
    );
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
            $this->addFlash('success', 'Reservation modifier avec succée !');
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

      public function showR(ReservationRepository $repositoryR,ProductRepository $repositoryP,)
      {
          $c= $repositoryR->findBy(['user' => $this->getUser()]);
          //dd($c);
          return $this->render("Reservation/showReservation.html.twig",
          ["Reservation"=>$c]);
        }


        

         
             

 #[Route('/addReservation', name: 'app_addReservation')]
    public function addReservation(ManagerRegistry $doctrine,Request $request,ReservationRepository $repository,ProductRepository $repository2, PaginatorInterface $paginator)
    {
        $cc= $repository->findAll();
          $c = $paginator->paginate(
            $cc, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            4 // Nombre de résultats par page
        );
        $Reservation= new Reservation();
        //$product= new Product();
        $form=$this->createForm(ReservationFormType::class,$Reservation);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            foreach($Reservation->getIdProduit() as $i)
            {
                $product= $repository2->find($i);
                if($product->getQuantite()-$Reservation->getQuantite()>=0)
                {
                    $etat=0;
                    $product->setQuantite($product->getQuantite()-$Reservation->getQuantite()) ;
                }
                    else if($product->getQuantite()-$Reservation->getQuantite()<0)
                    $etat=1;
                   
            }
            if($etat==0)
            {
                $Reservation->setUser($this->getUser());
                $em =$doctrine->getManager() ;
                $em->persist($Reservation);
                $em->flush();
                $this->addFlash('success', 'Reservation effectuer avec succée !');
                return $this->redirectToRoute("app_addReservation");
            }
            else if($etat==1)
                $this->addFlash('error', 'quantite en stocke insuffisante !');
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






     #[Route('/addReservationFront/{id}', name: 'app_addReservationFront')]
    public function addReservationFront(ManagerRegistry $doctrine,Request $request,$id,ProductRepository $repository,MailerInterface $mailer)
    {
        $product= $repository->find($id);
        $Reservation= new Reservation();
        $form=$this->createForm(ReservationFrontFormType::class,$Reservation);
        $form->handleRequest($request);
        $Reservation->addIdProduit($product);
        $Reservation->setEtat('en cours');
        $Reservation->setUser($this->getUser());
        if($form->isSubmitted()){
            if($product->getQuantite()-$Reservation->getQuantite()>=0)
                {
                    $product->setQuantite($product->getQuantite()-$Reservation->getQuantite()) ;
                    $em =$doctrine->getManager() ;
                    $em->persist($Reservation);
                    $em->flush();
                    $this->addFlash('success', 'Reservation effectuer avec succée !');
                    
                    $email = (new Email())
                    ->from('commercial.edusex@gmail.com')
                    ->to($Reservation->getUser()->getEmail())
                    ->subject('Votre Reservation Est Confirmer !')
                    
                    ->html('
                    <p>Cher(e) Client, </p>,
                    <p>Nous sommes ravis de vous confirmer que votre réservation a bien été confirmée. Nous vous remercions de votre confiance et sommes impatients de vous accueillir parmi nous.</p>
                    <p>Si vous avez des questions ou des préoccupations concernant votre réservation, n"hésitez pas à nous contacter.</p>
                    <p>Nous ferons de notre mieux pour répondre à toutes vos demandes.</p>
                    <p>Nous sommes impatients de vous voir bientôt. Merci encore d"avoir choisi Edusex.</p>
                    <p>Cordialement,</p>
                    <p>Edusex</p>

                    ')
                    
                    ; 


                    // Cher(e) [nom du client],

                    // Nous sommes ravis de vous confirmer que votre réservation pour [nom de l'événement, la chambre, la table, etc.] 
                    //a bien été confirmée. Nous vous remercions de votre confiance et sommes impatients de vous accueillir parmi nous.
                    
                    // Veuillez noter que les détails de votre réservation sont les suivants :
                    
                    // Date d'arrivée : [date]
                    // Date de départ : [date]
                    // Type de chambre, de table, ou autre : [nom]
                    // Montant total : [montant]
                    // Si vous avez des questions ou des préoccupations concernant votre réservation, n'hésitez pas à nous contacter. 
                    //Nous ferons de notre mieux pour répondre à toutes vos demandes.
                    
                    // Nous sommes impatients de vous voir bientôt. Merci encore d'avoir choisi notre entreprise.
                    
                    // Cordialement,
                    // [L'équipe de l'entreprise]






        
                $mailer->send($email);
                    return $this->redirectToRoute("afficheP");
                }
                else if($product->getQuantite()-$Reservation->getQuantite()<0)
                $this->addFlash('error', 'quantite en stocke insuffisante !');

        }
        else {
            // Form is not valid, retrieve the errors
            $errors = $form->getErrors();
        }
       
        return $this->render("reservation/reservation_front.html.twig", [
        'formClass' => $form->createView(),
        "Product"=>$product,
    ]);
     }


     #[Route('/showReservationsJSON', name: 'app_showReservationsJSON')]
    public function showReservationsJSON(ReservationRepository $repository,Request $request,NormalizerInterface $normalizer)
    {
        $cc= $repository->findAll(); 
        $data = [];

        foreach ($cc as $c) {
            $idProduit = [];

            
                foreach ($c->getIdProduit() as $Produit)
                $idProduit[] = [
                    'idProduit' => $Produit->getId(),
                ];
            

            $data[] = [
                'id' => $c->getId(),
                'quantite' => $c->getQuantite(),
                'dateReservation' => $c->getDateReservation(),
                'etat' => $c->getEtat(),
                'Produit' => $idProduit,
            ];
        }
        
            $normalized = [$normalizer->normalize($data,'json',['groups'=>'reservation_list'])];
            //$jason = json_encode($normalized);
        
            
         $jason = json_encode($normalized);
        return new Response($jason);
     }


     #[Route('/addReservationJSON', name: 'app_addReservationJSON')]
    public function addReservationJSON(ManagerRegistry $doctrine,Request $request,SerializerInterface $serializer,ProductRepository $repository,UserRepository $UserRepository)
    {
        
        $Reservations= new Reservation();
        $user=$UserRepository->find($request->get("userId"));
        $Reservations->setUser($user);
        $Reservations->setQuantite($request->get("quantite"));
        //$date = DateTime::createFromFormat('Y-m-d H:m:s', $req->get('date'));
        $dateReservation = DateTime::createFromFormat('Y-m-d H:m:s', $request->get("dateReservation"));
        $Reservations->setDateReservation($dateReservation);
        $Reservations->setEtat($request->get("etat"));
        //$Reservations->addIdProduit($request->get("idProduit"));
        $product= $repository->find($request->get("idProduit"));
        $Reservations->addIdProduit($product);
        //$Reservations->setUser($this->getUser());
        //dd($Reservations);
        $em =$doctrine->getManager() ;
        $em->persist($Reservations);
        $em->flush();
        $data = $serializer->serialize($Reservations,'json',['groups'=>'reservation_list']);
        return new Response($data);
     }//http://127.0.0.1:8000/addReservationJSON?quantite=2&dateReservation=2025-01-01T01:01:00Z&etat=en%20cours&idProduit=21


     #[Route('/updateReservationJSON/{id}', name: 'app_updateReservationJSON')]
    public function updateReservationJSON(ManagerRegistry $doctrine,Request $request,SerializerInterface $serializer,ReservationRepository $repository,ProductRepository $repository2,$id)
    {


        $Reservations= new Reservation();
        $Reservations= $repository->find($id);
        $Reservations->setQuantite($request->get("quantite"));
        $dateReservation = new \DateTime($request->get("dateReservation"));
        $Reservations->setDateReservation($dateReservation);
        $Reservations->setEtat($request->get("etat"));
        //$Reservations->addIdProduit($request->get("idProduit"));
        $product= $repository2->find($request->get("idProduit"));
        $Reservations->addIdProduit($product);
        
        
        $em =$doctrine->getManager() ;
        //$em->persist($Reservations);
        $em->flush();
        $data = $serializer->serialize($Reservations,'json',['groups'=>'reservation_list']);
        return new Response($data);
     }//http://127.0.0.1:8000/addReservationJSON?quantite=2&dateReservation=2025-01-01T01:01:00Z&etat=en%20cours&idProduit=21

     #[Route('/pdfReservation', name: 'app_pdfReservation')]
     public function exportPdf(ReservationRepository $repositoryR)
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
        $html = $this->renderView('PDF/listReservationPDF.html.twig', [
            "Reservation"=>$c
        ]);

        // set content
        $pdf->writeHTML($html, true, false, true, false, '');

        // output PDF
        $pdf->Output('example.pdf', 'D');

        // return response
        return new Response('PDF exported successfully!');
    }
     


}
