<?php

namespace App\Controller;

use App\Entity\CarBody;
use App\Entity\Engine;
use App\Form\ChoicesEngineType;
use App\Repository\CarBodyRepository;
use App\Repository\EngineRepository;
use App\Repository\GenerationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Serializer;

#[Route('/new-cars')]
#[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
class NewCarsController extends AbstractController
{
    private $generationRepository;
    private $carBodyRepository;
    private $formFactory;
    private $engineRepository;
    private $serializer;

    public function __construct(
        GenerationRepository $generationRepository,
        CarBodyRepository $carBodyRepository,
        FormFactoryInterface $formFactory,
        EngineRepository $engineRepository,
        Serializer $serializer
    ) {
        $this->generationRepository = $generationRepository;
        $this->carBodyRepository = $carBodyRepository;
        $this->formFactory = $formFactory;
        $this->engineRepository = $engineRepository;
        $this->serializer = $serializer;
    }

    #[Route('/now/', name: 'new_cars_now_body')]
    public function carNowChoosingBody(): Response
    {
        $generations = $this->generationRepository->getNewGenerations();

//        $json = $this->serializer->serialize($generations,'json');
//        dd($json);
        return $this->render('new_cars/index.html.twig', [
            'generations' => $generations
        ]);
    }
    #[Route('/now/{body}/', name: 'new_cars_now_engine')]
    #[ParamConverter('body', options: ['mapping' => ['body' => 'name']])]
    public function CarNowChoosingEngine(CarBody $body): Response
    {
        //$engine = $this->engineRepository->getEngineWithCarBodyGenerationBrandModelRelation($brand,$model,$generation,$body);

        $generation = $this->generationRepository->getNewGenerations();

        $form = $this->formFactory->create(ChoicesEngineType::class,[],[
            //'engine' => $engine
        ]);

        return $this->render('new_cars/index.html.twig', [
            'generations' => $generation
        ]);
    }
    #[Route('/now/{body}/{engine}/', name: 'new_cars_now_all')]
    #[ParamConverter('body', options: ['mapping' => ['body' => 'name']])]
    #[ParamConverter('engine', options: ['mapping' => ['engine' => 'name']])]
    public function CarNowAllChoosing(CarBody $body, Engine $engine): Response
    {
        $generation = $this->generationRepository->getNewGenerations();



        return $this->render('new_cars/index.html.twig', [
            'generations' => $generation,
            //'form' => $form->createView()
        ]);
    }

    //
    #[Route('/year-ago/', name: 'new_cars_ago')]
    public function CaryearAgo(): Response
    {
        $generation = $this->generationRepository->getNewGenerationsYearAgo();

        return $this->render('new_cars/index.html.twig', [
        ]);
    }
}
