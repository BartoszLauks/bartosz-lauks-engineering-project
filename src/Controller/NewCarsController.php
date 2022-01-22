<?php

namespace App\Controller;

use App\Entity\CarBody;
use App\Entity\Engine;
use App\Entity\Generation;
use App\Repository\BrandRepository;
use App\Repository\CarBodyRepository;
use App\Repository\EngineRepository;
use App\Repository\GenerationRepository;
use App\Repository\ModelRepository;
use Doctrine\ORM\NonUniqueResultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

#[Route('/new-cars')]
#[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
class NewCarsController extends AbstractController
{
    private GenerationRepository $generationRepository;
    private CarBodyRepository $carBodyRepository;
    private EngineRepository $engineRepository;
    private NormalizerInterface $normalizer;
    private ModelRepository $modelRepository;
    private BrandRepository $brandRepository;


    public function __construct(
        GenerationRepository $generationRepository,
        CarBodyRepository $carBodyRepository,
        EngineRepository $engineRepository,
        NormalizerInterface $normalizer,
        ModelRepository $modelRepository,
        BrandRepository $brandRepository
    ) {
        $this->generationRepository = $generationRepository;
        $this->carBodyRepository = $carBodyRepository;
        $this->engineRepository = $engineRepository;
        $this->normalizer = $normalizer;
        $this->modelRepository = $modelRepository;
        $this->brandRepository = $brandRepository;
    }

    #[Route('/now/', name: 'new_cars_now_generation')]
    public function carNowChoosingGeneration(): Response
    {
        $generations = $this->generationRepository->getNewGenerations();

        try {
            $array = $this->normalizer->normalize($generations, null, ['groups' => ['new_car']]);
        } catch (ExceptionInterface) {
            throw new HttpException(500,"Error");
        }

        return $this->render('new_cars/selectGeneration.html.twig', [
            'generations' => $array,
            'now' => true
        ]);
    }

    #[Route('/now/{generation}/', name: 'new_cars_now_body')]
    #[ParamConverter('generation', options: ['mapping' => ['generation' => 'name']])]
    public function carNowChoosingBody(Generation $generation): Response
    {
        $bodys = $this->carBodyRepository->getNewCarBodyByGeneration($generation);
        if (empty($bodys)) {
            throw new NotFoundHttpException();
        }

        return $this->render('new_cars/selectCarBody.html.twig', [
            'bodys' => $bodys,
            'generation' => $generation->getName(),
            'now' => true
        ]);
    }

    #[Route('/now/{generation}/{body}/', name: 'new_cars_now_engine')]
    #[ParamConverter('generation', options: ['mapping' => ['generation' => 'name']])]
    #[ParamConverter('body', options: ['mapping' => ['body' => 'name']])]
    public function CarNowChoosingEngine(Generation $generation, CarBody $body): Response
    {
        $engines = $this->engineRepository->getNewEngineByCarBody($generation,$body);
        if (empty($engines)) {
            throw new NotFoundHttpException();
        }

        return $this->render('new_cars/selectEngine.html.twig', [
            'engines' => $engines,
            'generation' => $generation->getName(),
            'body' => $body->getName(),
            'now' => true

        ]);
    }
    #[Route('/now/{generation}/{body}/{engine}/', name: 'new_cars_now_all')]
    #[ParamConverter('generation', options: ['mapping' => ['generation' => 'name']])]
    #[ParamConverter('body', options: ['mapping' => ['body' => 'name']])]
    #[ParamConverter('engine', options: ['mapping' => ['engine' => 'name']])]
    public function CarNowAllChoosing(Generation $generation, CarBody $body, Engine $engine): Response
    {
        $engines = $this->engineRepository->getNewEngineByCarBody($generation,$body);
        if (empty($engines)) {
            throw new NotFoundHttpException();
        }

        $model = $this->modelRepository->getOneModelByGeneration($generation, $body, $engine);
        if (empty($model)) throw new NotFoundHttpException();
        $brand = $this->brandRepository->getOneBrandByModel($model[0],$generation, $body, $engine);
        if (empty($brand)) throw new NotFoundHttpException();;

        return $this->render('new_cars/selectAll.html.twig', [
            'brand' => $brand[0],
            'model' => $model[0],
            'generation' => $generation,
            'body' => $body,
            'engine' => $engine,
            'now' => true
        ]);
    }

    #[Route('/year-ago/', name: 'new_cars_year_ago_generation')]
    public function carYearAgoChoosingGeneration(): Response
    {
        $generations = $this->generationRepository->getNewGenerationsYearAgo();

        try {
            $array = $this->normalizer->normalize($generations, null, ['groups' => ['new_car']]);
        } catch (ExceptionInterface) {
            throw new HttpException(500,"Error");
        }

        return $this->render('new_cars/selectGeneration.html.twig', [
            'generations' => $array
        ]);
    }

    #[Route('/year-ago/{generation}/', name: 'new_cars_year_ago_body')]
    #[ParamConverter('generation', options: ['mapping' => ['generation' => 'name']])]
    public function carYearAgoChoosingBody(Generation $generation): Response
    {
        $bodys = $this->carBodyRepository->getNewCarBodyByGeneration($generation);
        if (empty($bodys)) {
            throw new NotFoundHttpException();
        }

        return $this->render('new_cars/selectCarBody.html.twig', [
            'bodys' => $bodys,
            'generation' => $generation->getName()
        ]);
    }

    #[Route('/year-ago/{generation}/{body}/', name: 'new_cars_year_ago_engine')]
    #[ParamConverter('generation', options: ['mapping' => ['generation' => 'name']])]
    #[ParamConverter('body', options: ['mapping' => ['body' => 'name']])]
    public function CarYearAgoChoosingEngine(Generation $generation, CarBody $body): Response
    {
        $engines = $this->engineRepository->getNewEngineByCarBody($generation,$body);
        if (empty($engines)) {
            throw new NotFoundHttpException();
        }

        return $this->render('new_cars/selectEngine.html.twig', [
            'engines' => $engines,
            'generation' => $generation->getName(),
            'body' => $body->getName()

        ]);
    }
    #[Route('/year-ago/{generation}/{body}/{engine}/', name: 'new_cars_year_ago_all')]
    #[ParamConverter('generation', options: ['mapping' => ['generation' => 'name']])]
    #[ParamConverter('body', options: ['mapping' => ['body' => 'name']])]
    #[ParamConverter('engine', options: ['mapping' => ['engine' => 'name']])]
    public function CarYearAgoAllChoosing(Generation $generation, CarBody $body, Engine $engine): Response
    {
        $engines = $this->engineRepository->getNewEngineByCarBody($generation,$body);
        if (empty($engines)) {
            throw new NotFoundHttpException();
        }

        $model = $this->modelRepository->getOneModelByGeneration($generation, $body, $engine);
        if (empty($model)) throw new NotFoundHttpException();
        $brand = $this->brandRepository->getOneBrandByModel($model[0],$generation, $body, $engine);
        if (empty($brand)) throw new NotFoundHttpException();

        return $this->render('new_cars/selectAll.html.twig', [
            'brand' => $brand[0],
            'model' => $model[0],
            'generation' => $generation,
            'body' => $body,
            'engine' => $engine
        ]);
    }
}
