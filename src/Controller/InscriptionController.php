<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Inscription;
use App\Entity\Product;
use App\Entity\UserCertif;
use App\Entity\Formation;
use App\Repository\FormationRepository;
use App\Repository\InscriptionRepository;
use App\Repository\CertificationRepository;

class InscriptionController extends AbstractController
{
    #[Route('/addInscription/{id}', name: 'inscription_add')]
    public function add(Formation $product,ManagerRegistry $doctrine): Response
    {
        $inscription = new Inscription();
        $inscription->setIdPersonnel($this->getUser());
        $inscription->setIdFormation($product);
        $inscription->setPresent(false);
        $em= $doctrine->getManager();
        $em->persist($inscription);
        $em->flush();

        return $this->redirectToRoute('afficheC', ['id' => $product->getId()]);
    }

    #[Route('/suppInscription/{id}', name: 'inscription_remove')]
    public function remove(Inscription $inscription,ManagerRegistry $doctrine): Response
    {
        $em= $doctrine->getManager();
        $em->remove($inscription);
        $em->flush();

        return $this->redirectToRoute('afficheC', ['id' => $inscription->getIdFormation()->getId()]);
    }


    

    #[Route('/afficheInscription', name: 'inscription_affiche')]
    public function index(InscriptionRepository $InscriptionRepository,FormationRepository $FormationRepository): Response
    {
        $inscriptions = $InscriptionRepository->findBy(['user' => $this->getUser()]);
        //$Product[] = new Product;
        $favoritid = new Inscription;
        foreach($inscriptions as $inscription)
        {
            $favoritid= $InscriptionRepository->find($inscription->getId());
           // $prodid = $inscriptionRepository->find($inscription->getProduct()->getId());
            $Inscription[]=[
                'id' => $favoritid->getIdFormation()->getId(),
                'dateFormation' => $favoritid->getIdFormation()->getDateFormation(),
                'libelle' => $favoritid->getIdFormation()->getLibelle(),
                'description' => $favoritid->getIdFormation()->getDescription(),
                'image' => $favoritid->getIdFormation()->getImage(),
        ];
           // $Products[]=[$Product];
        }


        return $this->render('inscription/index.html.twig', [
            'Product' => $Inscription,
        ]);
    }


    #[Route('/afficheInscriptionBack/{id}', name: 'inscriptionBack_affiche')]
    public function show(InscriptionRepository $InscriptionRepository,FormationRepository $FormationRepository,$id): Response
    {
        $inscriptions = $InscriptionRepository->findBy(['id_formation' => $id]);
        //$Product[] = new Inscription;
        foreach($inscriptions as $inscription)
        {
            $Product[]=[
                'id' => $inscription->getId(),
                'present' => $inscription->isPresent(),
                'id_personnel' => $inscription->getIdPersonnel()->getNom(),
                'id_Formation' => $inscription->getIdFormation()->getLibelle(),
        ];
        //dd($Product);
    }
    //dd($Product);
        return $this->render('inscription/index.html.twig', [
            'inscriptions' => $Product
        ]);
    }

    #[Route('/updateInscription/{id}', name: 'inscription_update')]
    public function update(ManagerRegistry $doctrine,$id,InscriptionRepository $InscriptionRepository,CertificationRepository $certifRepo): Response
    {
        $inscription = new Inscription();
        $inscription = $InscriptionRepository->find($id);
        //$inscription->setIdPersonnel($this->getUser());
       // $inscription->setIdFormation($product);
       if($inscription->isPresent())
       {
        $inscription->setPresent(false);
       }
        
        else
        {
            $inscription->setPresent(true);
            $formation = $inscription->getIdFormation()->getId();
            $certif = $certifRepo->findOneBy(['idFormation' => $formation]);
            $userCertif = new UserCertif;
            $userCertif->setIdCertif($certif);
            $userCertif->setIdPersonnel($this->getUser());
            $em= $doctrine->getManager();
            $em->persist($userCertif);
            $em->flush();
        }
       // $inscription->setPresent('true');
        $em= $doctrine->getManager();
        $em->flush();

        return $this->redirectToRoute('inscriptionBack_affiche', ['id' => $inscription->getIdFormation()->getId()]);
    }

}
