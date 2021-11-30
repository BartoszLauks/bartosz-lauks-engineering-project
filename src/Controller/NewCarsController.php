<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NewCarsController extends AbstractController
{
    #[Route('/new/cars', name: 'new_cars')]
    public function index(): Response
    {
        return $this->render('new_cars/index.html.twig', [
            'controller_name' => 'NewCarsController',
        ]);
    }
}
