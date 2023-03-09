<?php

namespace App\Controller;
namespace App\Controller;
use App\Entity\Sponser;
use App\Form\SponserType;
use App\Repository\SponserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use TCPDF;
class SponsorfrontController extends AbstractController
{
    #[Route('/sponsorfront', name: 'app_sponsorfront')]
    public function index(): Response
    {
        return $this->render('sponsorfront/index.html.twig', [
            'controller_name' => 'SponsorfrontController',
        ]);
    }
    #[Route('/frontsponsor', name: 'frontsponsor')]

    public function frontsponsor(SponserRepository $repository,PaginatorInterface $paginator,Request $request)
    {

        $c= $repository->findAll();
        $cc= $paginator->paginate(
            $c, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            4// Nombre de résultats par page
        );
        $sponser= $repository->findAll();
        return $this->render("sponsorfront/frontsponsor.html.twig",
        ["sponsers"=>$cc]);
      }

      #[Route('/showsponsor/{id}', name: 'showsponsor')]

    public function showsponsor(SponserRepository $repository,$id)
    {
        $sponser= $repository->find($id);
        return $this->render("sponsorfront/showsponsor.html.twig",
        ["sponsers"=>$sponser]);
      }

//       #[Route('/addSponserJSON', name: 'app_addSponserJSON')]
//       public function addSponserJSON(FormationRepository $repository,ManagerRegistry $doctrine,Request $request,SerializerInterface $serializer)
//       {
          
//           $Sponser= new Sponser();
 
//           $idFormation = $repository -> find($request->get("idFormation"));
//           $Sponser->setIdFormation($idFormation);
          
//           $dateSponser = new \DateTime($request->get("dateCertif"));
//           $Sponser->setDateCertif($dateSponser);
  
//           $imagePath = urldecode($_GET['image']);
//           $fileName = md5(uniqid()).'.'.pathinfo($imagePath, PATHINFO_EXTENSION);
//           copy($imagePath, $this->getParameter('images_directory') . '/' . $fileName);
//           $Sponser->setImage($fileName);
//           $em =$doctrine->getManager() ;
//           $em->persist($Sponser);
//           $em->flush();
//           $jason = $serializer->serialize($Sponser,'json',['groups'=>'certification_list']);
//           return new Response($jason);
//        }
//   //http://127.0.0.1:8000/addSponserJSON?idFormation=31&dateCertif=2025-05-01T01:01:00Z&image=C:%2FUsers%2FASUS%2FDownloads%2F_MG_4193.jpg
       
//   #[Route('/updateSponserJSON/{id}', name: 'app_updateSponserJSON')]
//      public function updateSponserJSON(FormationRepository $Frepository,SponserRepository $repository,ManagerRegistry $doctrine,Request $request,SerializerInterface $serializer,$id)
//      {
//          $Sponser= new Sponser();
//          $Sponser= $repository->find($id);
//          // $Sponser->setDateSponser($request->get("dateCertif"));
 
//          $dateCertif = new \DateTime($request->get("dateCertif"));
//          $Sponser->setDateCertif($dateCertif);
//          $w=$request->get("idFormation");
//          $idFormation= new Formation();
//          $idFormation = $Frepository -> find($w);
//          $Sponser->setIdFormation($idFormation);
 
//          // $Sponser->setIdCertif($request->get("idCertif"));
//          // $Sponser->setInscriptions($request->get("inscriptions"));
         
//          $imagePath = urldecode($_GET['image']);
//          $fileName = md5(uniqid()).'.'.pathinfo($imagePath, PATHINFO_EXTENSION);
//          copy($imagePath, $this->getParameter('images_directory') . '/' . $fileName);
//          $Sponser->setImage($fileName);
//          //$Reservations->addIdProduit($request->get("idProduit"));
//          $em =$doctrine->getManager() ;
//          //$em->persist($Reservations);
//          $em->flush();
//          $data = $serializer->serialize($Sponser,'json',['groups'=>'Sponser_list']);
//          return new Response($data);
//       }
//      //http://127.0.0.1:8000/updateSponserJSON/22?idFormation=31&dateCertif=2025-01-01T01:01:00Z&image=C:%2FUsers%2FASUS%2FDownloads%2F_MG_4193.jpg
//      #[Route('/afficheCertifUser', name: 'CertifUser_affiche')]
//      public function afficheCertifUser(UserCertifRepository $userCertifRepository): Response
//      {
//          $userCertifs = $userCertifRepository->findBy(['id_personnel' => $this->getUser()]);
//         // dd($userCertifs);
//          //$Product[] = new Product;
//          $certifid = new UserCertif;
//          foreach($userCertifs as $userCertif)
//          {
//              $certifid= $userCertifRepository->find($userCertif->getId());
//             // $prodid = $favoriteRepository->find($favorite->getProduct()->getId());
//              $Sponser[]=[
//                  'id' => $certifid->getIdCertif()->getId(),
//                  'image' => $certifid->getIdCertif()->getImage(),
//                  'dateCertif' => $certifid->getIdCertif()->getDateCertif(),
//                  'idFormation' => $certifid->getIdCertif()->getIdFormation(),
                 
//          ];
//             // $Products[]=[$Product];
//          }
//  //dd($Product);
 
//          return $this->render('certif/userCertif.html.twig', [
//              'Sponser' => $Sponser,
//          ]);
//      }


 #[Route('/showSponsersJSON', name: 'app_showSponsersJSON')]
     public function showSponsersJSON(SponserRepository $repository,Request $request,NormalizerInterface $normalizer)
     {
         $cc= $repository->findAll(); 
         $data = [];
 
         foreach ($cc as $c) {
 
             $data[] = [
                 'id' => $c->getId(),
                 'nom_sponser' => $c->getNomSponser(),
                 'type' => $c->getType(),
                 'Evenement' => $c->getEvenement()->getNomEvent(),
             ];
          }        
             $normalized = [$normalizer->normalize($data,'json',['groups'=>'Sponsor_list'])];
             //$jason = json_encode($normalized);
             
          $jason = json_encode($normalized);
         return new Response($jason);
     }

     
     
     #[Route('/pdfProduct', name: 'app_pdfProduct')]
     public function exportPdf(SponserRepository $repositoryR)
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
        $html = $this->renderView('PDF/listSonsorPDF.html.twig', [
            "Sponser"=>$c
        ]);

        // set content
        $pdf->writeHTML($html, true, false, true, false, '');

        // output PDF
        $pdf->Output('example.pdf', 'D');

        // return response
        return new Response('PDF exported successfully!');
    }


}
