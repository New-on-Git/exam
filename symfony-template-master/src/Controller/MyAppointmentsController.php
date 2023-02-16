<?php

namespace App\Controller;

use App\Repository\BookingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MyAppointmentsController extends AbstractController
{
    #[Route('/logged/appointments', name: 'app_my_appointments')]
    public function index(BookingRepository $bookingRepository): Response
    {
        $userId = $this->getUser()->getId();
//        dd($userId);
        $rdvs = $bookingRepository->findBy(["bookingHasUser" => $userId ]);

        return $this->render('my_appointments/index.html.twig', [
            'controller_name' => 'MyAppointmentsController',
            'myRdvs' => $rdvs
        ]);
    }
}
