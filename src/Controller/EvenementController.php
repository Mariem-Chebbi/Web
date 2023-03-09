<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/evenement')]
class EvenementController extends AbstractController
{
    #[Route('/', name: 'app_evenement_index', methods: ['GET'])]
    public function index(EvenementRepository $evenementRepository,PaginatorInterface $paginator,Request $request): Response
    {   

        $c= $evenementRepository->findAll();
        $cc= $paginator->paginate(
            $c, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            5// Nombre de résultats par page
        );
        return $this->render('evenement/index.html.twig', [
            'evenements' => $cc,

        ]);
    }

    #[Route('/new', name: 'app_evenement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EvenementRepository $evenementRepository,MailerInterface $mailer, UserRepository $userRepository): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evenementRepository->save($evenement, true);

            $this->addFlash('success','Evenement Ajouté avec succés!');
            $users = $userRepository->findAll();
            foreach($users as $user)
            {
            $email = (new Email())
                    ->from('commercial.edusex@gmail.com')
                    ->to($user->getEmail())
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


        
                $mailer->send($email);}

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }
    
        return $this->renderForm('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_evenement_show', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_evenement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evenement $evenement, EvenementRepository $evenementRepository): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evenementRepository->save($evenement, true);
            $this->addFlash('success','Evenement modifié avec succés!');

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_evenement_delete', methods: ['POST'])]
    public function delete(Request $request, Evenement $evenement, EvenementRepository $evenementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->request->get('_token'))) {
            $evenementRepository->remove($evenement, true);
            $this->addFlash('success','Evenement supprimé avec succés !');
        }

        return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
    }

    
     
}