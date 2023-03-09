<?php

namespace App\Controller;

use App\Entity\Sponser;
use App\Form\SponserType;
use App\Repository\SponserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Knp\Component\Pager\PaginatorInterface;


#[Route('/sponsor')]
class SponsorController extends AbstractController
{
    #[Route('/', name: 'app_sponsor_index', methods: ['GET'])]
    public function index(SponserRepository $sponserRepository,PaginatorInterface $paginator,Request $request): Response
    {    
        $c= $sponserRepository->findAll();
        $cc= $paginator->paginate(
            $c, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            4// Nombre de résultats par page
        );
        return $this->render('sponsor/index.html.twig', [
            'sponsers' => $cc,
        ]);
    }

    #[Route('/new', name: 'app_sponsor_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SponserRepository $sponserRepository): Response
    {
        $sponser = new Sponser();
        $form = $this->createForm(SponserType::class, $sponser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sponserRepository->save($sponser, true);
            $this->addFlash('success','Sponsor Ajouté!');

            return $this->redirectToRoute('app_sponsor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sponsor/new.html.twig', [
            'sponser' => $sponser,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sponsor_show', methods: ['GET'])]
    public function show(Sponser $sponser): Response
    {
        return $this->render('sponsor/show.html.twig', [
            'sponser' => $sponser,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_sponsor_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Sponser $sponser, SponserRepository $sponserRepository): Response
    {
        $form = $this->createForm(SponserType::class, $sponser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sponserRepository->save($sponser, true);
            $this->addFlash('success','Sponsor Modifié avec succés!');

            return $this->redirectToRoute('app_sponsor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sponsor/edit.html.twig', [
            'sponser' => $sponser,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sponsor_delete', methods: ['POST'])]
    public function delete(Request $request, Sponser $sponser, SponserRepository $sponserRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sponser->getId(), $request->request->get('_token'))) {
            $sponserRepository->remove($sponser, true);
            $this->addFlash('success','Sponsor supprimé avec succés !');
        }

        return $this->redirectToRoute('app_sponsor_index', [], Response::HTTP_SEE_OTHER);
    }

    // public function getSponsors(SponserRepository $repo, SerializerInterface $serializerInterface)
    // {
    // $sponsers=$repo->findall();
    // $json=$serializerInterface->serialize($sponsers,'json',['groups'=>'sponsers']);
    // dump($sponsers);
    // die ;
    // }
    // public function addsponsers(Request $request,SerializerInterface $serializer,EntityManagerInterface $em){

    // $content=$request->getContent();
    // $data=$serializer->deserialize($content,Sponser::class,'json') ;
    // $em->persist($data);
    // $em->flush();
    // return new Response('sponser added successfully');
    // }

}
