<?php

namespace App\Controller;

use App\Entity\Test;
use App\Form\TestType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    #[Route('/test', name: 'app_test')]
    public function index(): Response
    {
        return $this->render('test/index.html.twig', [
            'controller_name' => 'TestController',
        ]);
    }

    /**
     * @Route("/get-available-hours", name="get_available_hours", methods={"GET"})
     */
    public function getAvailableHours(Request $request)
    {
        $test = new Test();
        $form = $this->createForm(TestType::class, $test);
        $selectedDate = $request->request->get('selected_date');

        $availableHours = ['10:00', '11:00', '12:00', '13:00', '14:00'];
        return $this->renderForm('test/index.html.twig', [
            'form' => $form,
        ]);
    }
}
