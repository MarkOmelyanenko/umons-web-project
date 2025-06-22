<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\CoachRepository;

final class CoachController extends AbstractController
{
    #[Route('/coaches', name: 'coaches')]
    public function index(CoachRepository $coachRepository): Response
    {
        $coaches = $coachRepository->findAll();

        return $this->render('coach/index.html.twig', [
            'coaches' => $coaches,
        ]);
    }
}
