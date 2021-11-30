<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ChoosingComponentsController extends AbstractController
{
    #[Route('/choosing/components', name: 'choosing_components')]
    public function index(): Response
    {
        return $this->render('choosing_components/index.html.twig', [
            'controller_name' => 'ChoosingComponentsController',
        ]);
    }
}
