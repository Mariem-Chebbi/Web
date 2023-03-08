<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Certification;
use App\Entity\UserCertif;
use App\Entity\Formation;
use App\Form\CertificationFormType;
use App\Repository\CertificationRepository;
use App\Repository\UserCertifRepository;
use App\Repository\FormationRepository;

use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use TCPDF;
use Endroid\QrCode\QrCode;


class CertificationController extends AbstractController
{
    #[Route('/certification', name: 'app_certification')]
    public function index(): Response
    {
        return $this->render('certification/addCertification.html.twig', [
            'controller_name' => 'CertificationController',
        ]);
    }

    #[Route('/suppCertification/{id}', name: 'supprimerC')]

    public function suppC(ManagerRegistry $doctrine,$id,CertificationRepository $repository)
      {
      //récupérer le Certification à supprimer
          $Certification= $repository->find($id);
      //récupérer l'entity manager
          $em= $doctrine->getManager();
          $em->remove($Certification);
          $em->flush();
          return $this->redirectToRoute("app_addCertification");///////////////////////
      } 

      #[Route('/updatCertification/{id}', name: 'updatC')]

    public function updatC(PaginatorInterface $paginator,ManagerRegistry $doctrine,$id,CertificationRepository $repository,Request $request)
      {
      //récupérer le Certification à supprimer
      
      $c= $repository->findAll();
      $cc= $paginator->paginate(
          $c, // Requête contenant les données à paginer (ici nos articles)
          $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
          4 // Nombre de résultats par page
      );
          $Certification= $repository->find($id);
          $newCertification= new Certification();
          $form=$this->createForm(CertificationFormType::class,$newCertification);
          $form->get('dateCertif')->setData($Certification->getDateCertif());
          //$form->get('description')->setData($Certification->getDescription());
         
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $file = $form['image']->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );
            $newCertification->setImage($fileName);
            $em =$doctrine->getManager() ;
            $Certification->setImage($newCertification->getImage());
            $Certification->setDateCertif($newCertification->getDateCertif());
            $Certification->setIdFormation($newCertification->getIdFormation());
            $em->flush();
            
            $this->addFlash('success','Certification modifiée avec succès !');
            return $this->redirectToRoute("app_addCertification");
        }
        else {
            // Form is not valid, retrieve the errors
            $errors = $form->getErrors(true, false);

            // Display the errors
            
        }
        return $this->render("certif/addCertif.html.twig", [
            'formClass' => $form->createView(),
            "Certification"=>$cc,
        ]);
      } 

      /*#[Route('/updatCertification/{id}', name: 'updatP')]

    public function updatP(ManagerRegistry $doctrine,$id,CertificationRepository $repository,Request $request)
      {
      //récupérer le Certification à supprimer
          $Certification= $repository->find($id);
          $newCertification= new Certification();
          $form=$this->createForm(CertificationFormType::class,$newCertification);
        $form->handleRequest($request);
        if($form->isSubmitted()){
            $em =$doctrine->getManager() ;
            $Certification->setLibelle($newCertification->getLibelle());
            $Certification->setDescription($newCertification->getDescription());
            $Certification->setImage($newCertification->getImage());
            $em->flush();
            return $this->redirectToRoute("afficheP");
        }
        return $this->renderForm("Certification/updateCertification.html.twig",/////////////////////////////////////////////
        array("formClass"=>$form));//////////////////////////
      } */

    #[Route('/afficheCertification', name: 'afficheCertif')]
        public function showC(CertificationRepository $repository)
        {       
          $c= $repository->findAll();
          return $this->render("certif/showCertification.html.twig",
          ["Certification"=>$c]);
        }


 #[Route('/addCertification', name: 'app_addCertification')]
    public function addCertification(PaginatorInterface $paginator,ManagerRegistry $doctrine,Request $request,CertificationRepository $repository)
    {
        $c= $repository->findAll();
        $cc= $paginator->paginate(
            $c, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            4 // Nombre de résultats par page
        );

        $Certification= new Certification();
        $form=$this->createForm(CertificationFormType::class,$Certification);
        // $form->get('dateCertif')->setData(date());

        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $file = $form['image']->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );
            $Certification->setImage($fileName);
            $em =$doctrine->getManager() ;
            $em->persist($Certification);
            $em->flush();
            $this->addFlash('success','Certification crée avec succès !');
            return $this->redirectToRoute("app_addCertification");
        }
        else {
            // Form is not valid, retrieve the errors
            $errors = $form->getErrors();
        }
       
        return $this->render("certif/addCertif.html.twig", [
        'formClass' => $form->createView(),
        "Certification"=>$cc,
        
    ]);
    }

    #[Route('/showCertificationsJSON', name: 'app_showCertificationsJSON')]
    public function showCertificationsJSON(CertificationRepository $repository,Request $request,NormalizerInterface $normalizer)
    {
        $cc= $repository->findAll(); 
        $data = [];

        foreach ($cc as $c) {

            $data[] = [
                'id' => $c->getId(),
                'image' => $c->getImage(),
                'dateCertification' => $c->getDateCertif(),
                'Formation' => $c->getIdFormation()->getId(),
            ];
         }        
            $normalized = [$normalizer->normalize($data,'json',['groups'=>'certification_list'])];
            //$jason = json_encode($normalized);
            
         $jason = json_encode($normalized);
        return new Response($jason);
    }
     
     #[Route('/addCertificationJSON', name: 'app_addCertificationJSON')]
     public function addCertificationJSON(FormationRepository $repository,ManagerRegistry $doctrine,Request $request,SerializerInterface $serializer)
     {
         
         $Certification= new Certification();

         $idFormation = $repository -> find($request->get("idFormation"));
         $Certification->setIdFormation($idFormation);
         
         $dateCertification = new \DateTime($request->get("dateCertif"));
         $Certification->setDateCertif($dateCertification);
 
         $imagePath = urldecode($_GET['image']);
         $fileName = md5(uniqid()).'.'.pathinfo($imagePath, PATHINFO_EXTENSION);
         copy($imagePath, $this->getParameter('images_directory') . '/' . $fileName);
         $Certification->setImage($fileName);
         $em =$doctrine->getManager() ;
         $em->persist($Certification);
         $em->flush();
         $jason = $serializer->serialize($Certification,'json',['groups'=>'certification_list']);
         return new Response($jason);
      }
 //http://127.0.0.1:8000/addCertificationJSON?idFormation=31&dateCertif=2025-05-01T01:01:00Z&image=C:%2FUsers%2FASUS%2FDownloads%2F_MG_4193.jpg
      
 #[Route('/updateCertificationJSON/{id}', name: 'app_updateCertificationJSON')]
    public function updateCertificationJSON(FormationRepository $Frepository,CertificationRepository $repository,ManagerRegistry $doctrine,Request $request,SerializerInterface $serializer,$id)
    {
        $Certification= new Certification();
        $Certification= $repository->find($id);
        // $Certification->setDateCertification($request->get("dateCertif"));

        $dateCertif = new \DateTime($request->get("dateCertif"));
        $Certification->setDateCertif($dateCertif);
        $w=$request->get("idFormation");
        $idFormation= new Formation();
        $idFormation = $Frepository -> find($w);
        $Certification->setIdFormation($idFormation);

        // $Certification->setIdCertif($request->get("idCertif"));
        // $Certification->setInscriptions($request->get("inscriptions"));
        
        $imagePath = urldecode($_GET['image']);
        $fileName = md5(uniqid()).'.'.pathinfo($imagePath, PATHINFO_EXTENSION);
        copy($imagePath, $this->getParameter('images_directory') . '/' . $fileName);
        $Certification->setImage($fileName);
        //$Reservations->addIdProduit($request->get("idProduit"));
        $em =$doctrine->getManager() ;
        //$em->persist($Reservations);
        $em->flush();
        $data = $serializer->serialize($Certification,'json',['groups'=>'Certification_list']);
        return new Response($data);
     }
    //http://127.0.0.1:8000/updateCertificationJSON/22?idFormation=31&dateCertif=2025-01-01T01:01:00Z&image=C:%2FUsers%2FASUS%2FDownloads%2F_MG_4193.jpg
    #[Route('/afficheCertifUser', name: 'CertifUser_affiche')]
    public function afficheCertifUser(UserCertifRepository $userCertifRepository): Response
    {
        $userCertifs = $userCertifRepository->findBy(['id_personnel' => $this->getUser()]);
       // dd($userCertifs);
        //$Product[] = new Product;
        $certifid = new UserCertif;
        foreach($userCertifs as $userCertif)
        {
            $certifid= $userCertifRepository->find($userCertif->getId());
           // $prodid = $favoriteRepository->find($favorite->getProduct()->getId());
            $Certification[]=[
                'id' => $certifid->getIdCertif()->getId(),
                'image' => $certifid->getIdCertif()->getImage(),
                'dateCertif' => $certifid->getIdCertif()->getDateCertif(),
                'idFormation' => $certifid->getIdCertif()->getIdFormation(),
                
        ];
           // $Products[]=[$Product];
        }
//dd($Product);

        return $this->render('certif/userCertif.html.twig', [
            'Certification' => $Certification,
        ]);
    }

    #[Route('/pdfCertif/{id}', name: 'app_pdfCertif')]
     public function exportPdf(CertificationRepository $repositoryR,$id)
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
        $html = $this->renderView('PDF/certifPDF.html.twig', [
            "Certif"=>$c
        ]);

        // set content
        $pdf->writeHTML($html, true, false, true, false, '');

        // output PDF
        $pdf->Output('example.pdf', 'D');

        // return response
        return new Response('PDF exported successfully!');
    }


    // #[Route('/Certifications/{id}/generate_qr_code', name: 'generate_qr_code')]
    // public function generateQrCode(ManagerRegistry $doctrine,CertificationRepository $repository,Certification $certification,$id)
    // {
    //     // $CertifId = $request->request->get('id');
    //     // $Certif = $doctrine->getRepository(Certfification::class)->find($CertifId);
    //     // $imagePath = $this->getParameter('product_images_directory') . '/' . $Certif->getImage();
    //     // $imageContent = file_get_contents($imagePath);
    //     // $image = imagecreatefromstring($imageContent);
    //     // $qrCode = new QrCode($image);
    //     // $qrCodeDataUri = $qrCode->getDataUri();
    //     // return new JsonResponseonse(['qr_code_data_uri' => $qrCodeDataUri]);
    //     $certification = $doctrine->getRepository(Certification::class)->find($id);

    //     //$certification= $repository->find($id);
    //     $imagePath = "C:/Users/LENOVO/EdusexProject/public/images/". $certification->getImage();
        
    //     $imageContent = file_get_contents($imagePath);
    //     //dd($imageContent);
    //     $image = imagecreatefromstring($imageContent);
    //     $qrCode = new QrCode($image);
    //     $qrCodeDataUri = $qrCode->getDataUri();
    
    //     // return new Response($qrCodeDataUri, Response::HTTP_OK, [
    //     //     'Content-Type' => 'image/png',
    //     // ]);
    //     return $this->render('certif/qr_code.html.twig', [
    //         'qrCodeDataUri' => $qrCodeDataUri,
    //         'certification' => $certification,
    //     ]);
    // }
}
