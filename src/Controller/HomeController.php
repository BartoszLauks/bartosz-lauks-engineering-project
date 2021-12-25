<?php

namespace App\Controller;

use App\Repository\NewsesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $newsesRepository;

    public function __construct(
        NewsesRepository $newsesRepository
    ) {
        $this->newsesRepository = $newsesRepository;
    }

    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'newses' => $this->newsesRepository->getNewses()
        ]);
    }
}
