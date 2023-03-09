<?php

namespace App\Controller;

use App\Entity\CreneauHoraire;
use App\Form\AddCreneauHoraireType;
use App\Form\EditCreneauHoraireType;
use App\Repository\CreneauHoraireRepository;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

class CreneauHoraireController extends AbstractController
{
    #[Route('/creneau-horaire', name: 'app_creneau_horaire')]
    public function index(): Response
    {
        return $this->render('creneau_horaire/index.html.twig', [
            'controller_name' => 'CreneauHoraireController',
        ]);
    }

    #[Route('/creneau-horaire/add', name: 'add_creneau')]
    public function add(ManagerRegistry $doctrine, Request $request, UserRepository $userRepo): Response
    {
        $client=$this->getUser();
        //dd($client->getCentre()->getId());
        $showHeureError = false;
        $showJourError = false;
        $creneau = new CreneauHoraire();
        $form = $this->createForm(AddCreneauHoraireType::class, $creneau);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if (count($form->getErrors()) > 0) {
                $showHeureError = true;
            }
            if (count($form->get('jour')->getErrors()) > 0) {
                $showJourError = true;
            }
            $etat = $form->get('etat')->getData();
            if ($form->isValid() || $etat) {
                $client=$this->getUser();
                $psy = $userRepo->getPsyByCentre($client->getCentre()->getId());
                $cr = $form->getData();
                $jour = $form->get('jour')->getData();
                $heureDeb = $form->get('heureDebut')->getData();
                $heureFin = $form->get('heureFin')->getData();
                $etat = $form->get('etat')->getData();
                $creneau = $doctrine->getRepository(CreneauHoraire::class)->findOneBy(['jour' => $jour]);
                $creneau
                    ->setHeureDebut($heureDeb)
                    ->setHeureFin($heureFin)
                    ->setEtat($etat);
                foreach ($psy as $p){
                    $creneau->addPsychologue($p);
                }
                if ($cr->isEtat() == true) {
                    $creneau->setHeureDebut(0);
                    $creneau->setHeureFin(0);
                }
                $em = $doctrine->getManager();
                //$em->persist($creneau);
                $em->flush();
                return $this->redirectToRoute('list_creneau');
            }
        }
        return $this->render('creneau_horaire/add.html.twig', [
            'formAdd' => $form->createView(),
            'showHeureError' => $showHeureError,
            'showJourError' => $showJourError
        ]);
    }


    #[Route('/creneau-horaire/list', name: 'list_creneau')]
    public function list(CreneauHoraireRepository $repo, ManagerRegistry $doctrine): Response
    {
        $client=$this->getUser();
        $entityManager = $doctrine->getManager();
        $qp = $entityManager->createQueryBuilder();
        $qp->select('c')
        ->from(CreneauHoraire::class,'c')
        ->join('c.psychologue','p')
        ->where('p.id = :userId')
        ->setParameter('userId',$client->getId());

        $creneaux = $qp->getQuery()->getResult();
        //dd($creneaux);


        $order = array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi");

        usort($creneaux, function ($a, $b) use ($order) {
            $posA = array_search($a->getJour(), $order);
            $posB = array_search($b->getJour(), $order);
            return $posA - $posB;
        });
        //dd($creneaux);

        return $this->render('creneau_horaire/list.html.twig', [
            'creneaux' => $creneaux,
        ]);
    }

    #[Route('/creneau-horaire/edit/{id}', name: 'edit_creneau')]
    public function edit(CreneauHoraire $creneau, ManagerRegistry $doctrine, Request $request): Response
    {
        $showHeureError = false;
        $entityManager = $doctrine->getManager();

        $form = $this->createForm(AddCreneauHoraireType::class, $creneau);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if (count($form->getErrors()) > 0) {
                $showHeureError = true;
            }
            $show = true;
            $cr = $form->getData();
            $etat = $form->get('etat')->getData();

            if ($form->isValid() || $etat) {
                if ($cr->isEtat() == true) {
                    $creneau->setHeureDebut(0);
                    $creneau->setHeureFin(0);
                }
                $entityManager->flush();
                return $this->redirectToRoute('list_creneau');
            }
        }
        return $this->renderForm('creneau_horaire/edit.html.twig', [
            'formEdit' => $form,
            'creneau' => $creneau,
            'show' => $showHeureError
        ]);
    }


    #[Route('/creneau-horaire/get/', name: 'list_json_creneau', methods: ["GET"])]
    public function listJson(CreneauHoraireRepository $repo): Response
    {
        $creneaux = $repo->findAll();

        $order = array("Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi");

        usort($creneaux, function ($a, $b) use ($order) {
            $posA = array_search($a->getJour(), $order);
            $posB = array_search($b->getJour(), $order);
            return $posA - $posB;
        });
        //dd($creneaux);

        return $this->json($creneaux);
    }

    /**
     * @Route("/creneau-horaire/post/{jour}/{heureDebut}/{heureFin}/{etat}", name="add_json_creneau", methods={"GET"})
     */
    public function addJson(Request $request, ManagerRegistry $doctrine, string $jour, int $heureFin, int $heureDebut, string $etat): Response
    {
        $entityManager = $doctrine->getManager();
        $creneau = $doctrine->getRepository(CreneauHoraire::class)->findOneBy(['jour' => $jour]);

        $etat = ($etat === 'true');
        //dd($myBoolValue);

        $data = json_decode($request->getContent(), true);
        $creneau->setHeureDebut($heureDebut);
        $creneau->setHeureFin($heureFin);

        $creneau->setEtat($etat);

        //$entityManager->persist($creneau);
        $entityManager->flush();


        return $this->json("le creneau a été ajouter avec succès");
    }

    /**
     * @Route("/creneau-horaire/put/{id}/{heureDebut}/{heureFin}/{etat}", name="edit_json_creneau", methods={"GET"})
     */
    public function editJson(CreneauHoraire $creneau, Request $request, ManagerRegistry $doctrine, int $id, int $heureDebut, int $heureFin, string $etat): Response
    {
        $entityManager = $doctrine->getManager();
        $creneau = $doctrine->getRepository(CreneauHoraire::class)->findOneBy(['id' => $id]);

        $data = json_decode($request->getContent(), true);
        $etat = ($etat === 'true');
        $creneau->setHeureDebut($heureDebut);
        $creneau->setHeureFin($heureFin);
        $creneau->setEtat($etat);

        $entityManager->flush();


        return $this->json("le creneau a été editer avec succès");
    }

    /**
     * @Route("/creneau-horaire/get/heure/{jour}", name="get-heure_json", methods={"GET"})
     */
    public function getJsonHeures(ManagerRegistry $doctrine, string $jour, SerializerInterface $serializer)
    {
        $creneau = $doctrine->getRepository(CreneauHoraire::class)->findOneBy(['jour' => $jour]);
        $heure[] = [
            "id" => $creneau->getId(),
            "jour" => $creneau->getJour(),
            "heureDebut" => $creneau->getHeureDebut(),
            "heureFin" => $creneau->getHeureFin(),
            "etat" => $creneau->isEtat()
        ];

        $data = $serializer->serialize($heure, 'json');
        return  new JsonResponse($data, 200, [], true);
    }
}
