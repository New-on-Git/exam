<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LandingLoggedController extends AbstractController
{
    #[Route('/logged/landing', name: 'app_landing_logged')]
    public function index(UserRepository $userRepository): Response
    {
        $commercials = $userRepository->findAll();

        return $this->render('landing_logged/index.html.twig', [
            'controller_name' => 'LandingLoggedController',
            'Commercials' => $commercials
        ]);
    }
}
