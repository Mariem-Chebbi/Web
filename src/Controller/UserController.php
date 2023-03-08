<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;

use App\Form\UserFormType;

use App\Repository\UserRepository;


class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/addUser.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/suppUser/{id}', name: 'supprimerU')]
    public function suppU(ManagerRegistry $doctrine, $id, UserRepository $repository)
    {
        //récupérer le User à supprimer
        $User = $repository->find($id);
        //récupérer l'entity manager
        $em = $doctrine->getManager();
        $em->remove($User);
        $em->flush();
        return $this->redirectToRoute("app_addUser");///////////////////////
    }

    #[Route('/updatUser/{id}', name: 'updatU')]
    public function updatU(ManagerRegistry $doctrine, $id, UserRepository $repository, Request $request)
    {
        //récupérer le User à supprimer

        $c = $repository->findAll();
        $User = $repository->find($id);
        $newUser = new User();
        $form = $this->createForm(UserFormType::class, $newUser);
        $form->get('email')->setData($User->getEmail());
        $form->get('roles')->setData($User->getRoles());
        //$form->get('password')->setData($User->getPassword());
        $form->get('nom')->setData($User->getNom());
        $form->get('prenom')->setData($User->getPrenom());
        $form->get('num_tel')->setData($User->getNumTel());
        $form->get('ville')->setData($User->getVille());
        $form->get('date_naissance')->setData($User->getDateNaissance());


        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['image']->getData();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );
            $newUser->setImage($fileName);
            $em = $doctrine->getManager();
            $User->setEmail($newUser->getEmail());
            $User->setRoles($newUser->getRoles());
            // $User->setPassword($newUser->getPassword());
            $User->setNom($newUser->getNom());
            $User->setPrenom($newUser->getPrenom());
            $User->setNumTel($newUser->getNumTel());
            $User->setVille($newUser->getVille());
            $User->setDateNaissance($newUser->getDateNaissance());
            $User->setImage($newUser->getImage());
            $em->flush();
            return $this->redirectToRoute("app_addUser");
        } else {
            // Form is not valid, retrieve the errors
            $errors = $form->getErrors(true, false);

            // Display the errors

        }
        return $this->render("user/updateUser.html.twig", [
            'formClass' => $form->createView(),
            "User" => $c,
        ]);
    }

    /*#[Route('/updatUser/{id}', name: 'updatP')]

  public function updatP(ManagerRegistry $doctrine,$id,UserRepository $repository,Request $request)
    {
    //récupérer le User à supprimer
        $User= $repository->find($id);
        $newUser= new User();
        $form=$this->createForm(UserFormType::class,$newUser);
      $form->handleRequest($request);
      if($form->isSubmitted()){
          $em =$doctrine->getManager() ;
          $User->setLibelle($newUser->getLibelle());
          $User->setDescription($newUser->getDescription());
          $User->setImage($newUser->getImage());
          $em->flush();
          return $this->redirectToRoute("afficheP");
      }
      return $this->renderForm("User/updateUser.html.twig",/////////////////////////////////////////////
      array("formClass"=>$form));//////////////////////////
    } */

    #[Route('/afficheUser', name: 'afficheU')]
    public function showU(UserRepository $repository)
    {
        $c = $repository->findAll();
        return $this->render("User/showUser.html.twig",
            ["User" => $c]);
    }


    #[Route('/addUser', name: 'app_addUser')]
    public function addUser(ManagerRegistry $doctrine, Request $request, UserRepository $repository)
    {
        $c = $repository->findAll();
        $User = new User();
        $form = $this->createForm(UserFormType::class, $User);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['image']->getData();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move(
                $this->getParameter('images_directory'),
                $fileName
            );
            $User->setImage($fileName);
            $em = $doctrine->getManager();
            $em->persist($User);
            $em->flush();
            return $this->redirectToRoute("app_addUser");
        } else {
            // Form is not valid, retrieve the errors
            $errors = $form->getErrors();
        }

        return $this->render("user/addUser.html.twig", [
            'formClass' => $form->createView(),
            "User" => $c,

        ]);
    }

    #[Route('/showCertificationsJSON', name: 'app_showCertificationsJSON')]
    public function showCertificationsJSON(CertificationRepository $repository, Request $request, NormalizerInterface $normalizer)
    {
        $cc = $repository->findAll();
        $data = [];

        foreach ($cc as $c) {

            $data[] = [
                'id' => $c->getId(),
                'image' => $c->getImage(),
                'dateCertification' => $c->getDateCertif(),
                'Formation' => $c->getIdFormation()->getId(),
            ];
        }
        $normalized = [$normalizer->normalize($data, 'json', ['groups' => 'certification_list'])];
        //$jason = json_encode($normalized);

        $jason = json_encode($normalized);
        return new Response($jason);
    }

    #[Route('/addCertificationJSON', name: 'app_addCertificationJSON')]
    public function addCertificationJSON(FormationRepository $repository, ManagerRegistry $doctrine, Request $request, SerializerInterface $serializer)
    {

        $Certification = new Certification();

        $idFormation = $repository->find($request->get("idFormation"));
        $Certification->setIdFormation($idFormation);

        $dateCertification = new \DateTime($request->get("dateCertif"));
        $Certification->setDateCertif($dateCertification);

        $imagePath = urldecode($_GET['image']);
        $fileName = md5(uniqid()) . '.' . pathinfo($imagePath, PATHINFO_EXTENSION);
        copy($imagePath, $this->getParameter('images_directory') . '/' . $fileName);
        $Certification->setImage($fileName);
        $em = $doctrine->getManager();
        $em->persist($Certification);
        $em->flush();
        $jason = $serializer->serialize($Certification, 'json', ['groups' => 'certification_list']);
        return new Response($jason);
    }

    public function register(Request $request, ValidatorInterface $validator)
    {
        // ...

        $user = new User();
        $user->setPassword($request->request->get('password'));

        $errors = $validator->validate($user);

        if (count($errors) > 0) {
            // handle validation errors
        }

        // ...
    }

    #[Route('/user/recherche/by-email')]
    public function rechercheParSociete(Request $request, UserRepository $userRepository): Response
    {
        $searchValue = $request->get('search-value');
        if ($searchValue != null) {
            $users = $userRepository->findUserByEmail($searchValue);

            if ($users) {
                return new JsonResponse($users);
            } else {
                return new JsonResponse(null);
            }
        } else {
            return new JsonResponse(null);
        }
    }

    #[Route('/user/sort/by-field')]
    public function sortByField(Request $request, UserRepository $userRepository): Response
    {
        $searchValue = $request->get('sort-value');
        if ($searchValue != null) {

            $users = [];

            if ($searchValue == 1) {
                $users = $userRepository->orderByEmail();
            } else if ($searchValue == 2) {
                $users = $userRepository->orderByNom();
            } else  {
                $users = $userRepository->orderByPrenom();
            }

            if ($users) {
                return new JsonResponse($users);
            } else {
                return new JsonResponse(null);
            }
        } else {
            return new JsonResponse(null);
        }
    }
}
