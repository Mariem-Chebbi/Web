<?php

namespace App\Controller;

use App\Entity\RendezVous;
use App\Entity\User;
use App\Form\RendezVousType;
use App\Repository\CreneauHoraireRepository;
use App\Repository\RendezVousRepository;
use App\Repository\UserRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

use function PHPUnit\Framework\anything;

class RendezVousController extends AbstractController
{
    #[Route('/rendez/vous', name: 'app_rendez_vous')]
    public function index(): Response
    {
        return $this->render('rendez_vous/index.html.twig', [
            'controller_name' => 'RendezVousController',
        ]);
    }

    #[Route('/rdv/list', name: 'list_rdv')]
    public function list(RendezVousRepository $repo): Response
    {
        $rdvs = $repo->findAll();

        return $this->render('rendez_vous/list.html.twig', [
            'rdvs' => $rdvs,
        ]);
    }

    #[Route('/rdv/delete/{id}', name: 'delete_rdv')]
    public function delete(RendezVous $rdv, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($rdv);
        $entityManager->flush();

        return $this->redirectToRoute('list_rdv');
    }

    #[Route('/rdv/details/{id}', name: 'details_rdv')]
    public function details(RendezVous $rdv): Response
    {
        return $this->renderForm('rendez_vous/details.html.twig', [
            'rdv' => $rdv
        ]);
    }


    #[Route('/rdv/add', name: 'add_rdv')]
    public function add(ManagerRegistry $doctrine, Request $request, TranslatorInterface $translator, CreneauHoraireRepository $crRepo, RendezVousRepository $rdvRepo): Response
    {
        $erreur = "";
        $date = new DateTime();
        $personnel = new User();
        $showForm = false;
        $showheure = false;
        $heureDebut = 0;
        $heureFin = 0;
        $rdv = new RendezVous();

        $form1 = $this->createForm(RendezVousType::class, $rdv);
        $form2 = $this->createFormBuilder($rdv)
            ->add('heure', ChoiceType::class)
            ->add(
                'Valider',
                SubmitType::class,
                [
                    'attr' => [
                        'class' => 'btn btn-dark px-4',
                        'id' => 'form-submit'
                    ],
                ]
            )
            ->getForm();
        $form1->handleRequest($request);
        if ($form1->isSubmitted() && $form1->isValid()) {
            $showForm = true;
            //$personnel = $form1->get('id_personnel')->getData();
            $em = $doctrine->getManager();
            $em->persist($rdv);
            $em->flush();
        }

        $rdv = $rdvRepo->lastInsertedRDV();
        //dd($rdv);
        if ($rdv !== null)
            $date = $rdv->getdateRdv();
        //dd($date);
        $jour = $date->format('l');
        $jourtrans = $translator->trans($jour);

        $heureDebut = $crRepo->findOneBy(['jour' => $jourtrans])->getHeureDebut();
        $heureFin = $crRepo->findOneBy(['jour' => $jourtrans])->getHeureFin();


        if ($heureDebut == 0 && $heureFin == 0 && $showForm == true) {
            $erreur = "Le personnel n'est pas disponible";
        }

        $showheure = true;
        $range = range($heureDebut, $heureFin);
        $choices = array_combine($range, $range);

        $form2->remove('heure');
        $form2->remove('id_personnel');
        $form2->add('heure', ChoiceType::class, [
            'choices' => $choices,
            'attr' => [
                'class' => 'form-control',
            ],
        ]);


        $form2->handleRequest($request);
        if ($form2->isSubmitted()) {


            //dd($rdv);
            $heure = $form2->get('heure')->getData();
            //dd($heure);
            //$rdv->setDateRdv($date);
            $rdv->setHeure($heure);
            //$rdv->setIdPersonnel($personnel);
            $em = $doctrine->getManager();
            $em->persist($rdv);
            $em->flush();
            return $this->redirectToRoute('list_rdv');
        }


        return $this->renderForm('rendez_vous/add.html.twig', [
            'form' => $form1,
            'form2' => $form2,
            'showForm' => $showForm,
            'erreur' => $erreur,
            'heureDeb' => $heureDebut,
            'heureFin' => $heureFin
        ]);
    }
}
