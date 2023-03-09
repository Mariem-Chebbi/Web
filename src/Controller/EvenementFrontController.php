<?php

namespace App\Controller;
use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityRepository;
use App\Entity\Product;


use Doctrine\Persistence\ManagerRegistry;



class EvenementFrontController extends AbstractController
{
    #[Route('/evenement/front', name: 'app_evenement_front')]
    public function index(): Response
    {
        return $this->render('evenement_front/index.html.twig', [
            'controller_name' => 'EvenementFrontController',
        ]);
    }
    #[Route('/frontevent', name: 'frontevent')]

      public function frontevent(EvenementRepository $repository,PaginatorInterface $paginator,Request $request)
      {  $c= $repository->findAll();
        $cc= $paginator->paginate(
            $c, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            5// Nombre de résultats par page
        );
          $evenement= $repository->findAll();
          return $this->render("evenement_front/frontevent.html.twig",
          ["evenements"=>$cc]);
        }

        #[Route('/showevent/{id}', name: 'showevent')]

      public function showevent(EvenementRepository $repository,$id)
      {
          $evenement= $repository->find($id);
          return $this->render("evenement_front/showevent.html.twig",
          ["evenements"=>$evenement]);
        }
        #[Route('/email', name: 'email')]

             public function sendEmail(MailerInterface $mailer)
             {
                 $email = (new Email())
                     ->from('commercial.edusex@gmail.com')
                     ->to('chebili.mohamedali@esprit.tn')
                     ->subject('Hello from Symfony Mailer!')
                     ->text('Sending emails is fun again!')
                     ->html('<p>hello! a new Event has been added today !<em>fun</em> again!</p>');
             
                 $mailer->send($email);
             
                 return new Response("Success");
             }

             #[Route('/showEvenementsJSON', name: 'app_showEvenementsJSON')]
             public function showEvenementsJSON(EvenementRepository $repository,Request $request,NormalizerInterface $normalizer)
             {
                 $cc= $repository->findAll(); 
                 $data = [];
         
                 foreach ($cc as $c) {
         
                     $data[] = [
                         'id' => $c->getId(),
                         'nom_event' => $c->getNomEvent(),
                         'Lieu_event' => $c->getLieuEvent(),
                         'Description' => $c->getDescription(),
                         'Date_debut' => $c->getDateDebut(),
                         'Date_fin' => $c->getDateFin(),
                        //  'Date_fin' => $c->getSponser(),
                     ];
                  }        
                     $normalized = [$normalizer->normalize($data,'json',['groups'=>'Evenement_list'])];
                     //$jason = json_encode($normalized);
                     
                  $jason = json_encode($normalized);
                 return new Response($jason);
             }
          
             #[Route('/addEvenementJSON', name: 'app_addEvenementJSON')]
             public function addEvenementJSON(ManagerRegistry $doctrine,Request $request,SerializerInterface $serializer)
             {        
                 $Evenement= new Evenement();
                 $Evenement->setNomEvent($request->get("nom_event"));
                 $Evenement->setLieuEvent($request->get("lieu_event"));
                 $Evenement->setDescription($request->get("Description"));
                //  $Evenement->setDateDebut($request->get("Date_debut"));

                //  $Evenement->setDateFin($request->get("Date_fin"));       
                 $dateEvenement1 = new \DateTime($request->get("Date_debut"));

                 $Evenement->setDateDebut($dateEvenement1);
                 $dateEvenement2 = new \DateTime($request->get("Date_fin"));

                 $Evenement->setDateFin($dateEvenement2);
                 //$Evenement->setIdCertif($request->get("idCertif"));
                 //$Evenement->setInscriptions($request->get("inscriptions"));
                 $em =$doctrine->getManager() ;
                 $em->persist($Evenement);
                 $em->flush();
                 $jason = $serializer->serialize($Evenement,'json',['groups'=>'Evenement_list']);
                 return new Response($jason);
              }
         //http://127.0.0.1:8000/addEvenementJSON?nom_event=abir&lieu_event=abir&Description=abir&Date_debut=2025-01-01T01:01:00Z&Date_fin=2025-01-01T01:01:00Z

         #[Route('/updateEvenementJSON/{id}', name: 'app_updateEvenementJSON')]
    public function updateEvenementJSON(EvenementRepository $repository,ManagerRegistry $doctrine,Request $request,SerializerInterface $serializer,$id)
    {
        $Evenement= new Evenement();
        $Evenement= $repository->find($id);
        $Evenement->setNomEvent($request->get("nom_event"));
        $Evenement->setLieuEvent($request->get("lieu_event"));
        $Evenement->setDescription($request->get("Description"));
        $dateEvenement1 = new \DateTime($request->get("Date_debut"));
        $Evenement->setDateDebut($dateEvenement1);
        
        $dateEvenement2 = new \DateTime($request->get("Date_fin"));
        $Evenement->setDateFin($dateEvenement2);
        // $Evenement->setIdCertif($request->get("idCertif"));
        // $Evenement->setInscriptions($request->get("inscriptions"));
        
        
        //$Reservations->addIdProduit($request->get("idProduit"));
        $em =$doctrine->getManager() ;
        //$em->persist($Reservations);
        $em->flush();
        $data = $serializer->serialize($Evenement,'json',['groups'=>'Evenement_list']);
        return new Response($data);
     }
    //http://127.0.0.1:8000/updateEvenementJSON/25?nom_event=dikour&lieu_event=abir&Description=abir&Date_debut=2025-01-01T01:01:00Z&Date_fin=2025-01-01T01:01:00Z


    #[Route("/search", name:"search_evenement")]
     
    public function searchEvenement(Request $request,EvenementRepository $repository,PaginatorInterface $paginator)
    {
        $term = $request->query->get('term');
       
       
        
        $evenements = $repository->searchByName($term);
        $cc= $paginator->paginate(
            $evenements, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            5// Nombre de résultats par page
        );
        $results = [];
        foreach ($evenements as $evenement) {
            $results[] = [
                'id' => $evenement->getId(),
                'nomEvent' => $evenement->getNomevent(),
                'LieuEvent' => $evenement->getLieuevent(),
                'Description' => $evenement->getDescription(),
                'DateDebut' => $evenement->getDatedebut(),
                'DateFin' => $evenement->getDatefin(),
            ];
        }
        return $this->render('evenement/index.html.twig', [
            'evenements' => $cc,

        ]);
    }

    #[Route("/searchfront", name:"search_evenementfront")]
     
    public function searchEvenement1(Request $request,EvenementRepository $repository,PaginatorInterface $paginator)
    {
        $term = $request->query->get('term');
       
       
        
        $evenements = $repository->searchByName($term);
        $cc= $paginator->paginate(
            $evenements, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            2// Nombre de résultats par page
        );
        $results = [];
        foreach ($evenements as $evenement) {
            $results[] = [
                'id' => $evenement->getId(),
                'nomEvent' => $evenement->getNomevent(),
                'LieuEvent' => $evenement->getLieuevent(),
                'Description' => $evenement->getDescription(),
                'DateDebut' => $evenement->getDatedebut(),
                'DateFin' => $evenement->getDatefin(),
            ];
        }
        return $this->render('evenement_front/frontevent.html.twig', [
            'evenements' => $cc,

        ]);
    }
    
  
    
}
