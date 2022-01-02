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
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/new-cars')]
#[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
class NewCarsController extends AbstractController
{
    private $generationRepository;
    private $carBodyRepository;
    private $formFactory;
    private $engineRepository;
    private $serializerInterface;
    private $normalizer;
    private $denormalizer;
    private $modelRepository;
    private $brandRepository;


    public function __construct(
        GenerationRepository $generationRepository,
        CarBodyRepository $carBodyRepository,
        FormFactoryInterface $formFactory,
        EngineRepository $engineRepository,
        SerializerInterface $serializerInterface,
        NormalizerInterface $normalizer,
        DenormalizerInterface $denormalizer,
        ModelRepository $modelRepository,
        BrandRepository $brandRepository
    ) {
        $this->generationRepository = $generationRepository;
        $this->carBodyRepository = $carBodyRepository;
        $this->formFactory = $formFactory;
        $this->engineRepository = $engineRepository;
        $this->serializerInterface = $serializerInterface;
        $this->normalizer = $normalizer;
        $this->denormalizer = $denormalizer;
        $this->modelRepository = $modelRepository;
        $this->brandRepository = $brandRepository;
    }

    #[Route('/now/', name: 'new_cars_now_generation')]
    public function carNowChoosingGeneration(): Response
    {
        $generations = $this->generationRepository->getNewGenerations();

        $array = $this->normalizer->normalize($generations,null,['groups' => ['new_car']]); // to array

        //$json = $this->serializerInterface->serialize($generations,'json',['groups' => ['new_car']]);  // to json

        //$obj = $this->denormalizer->denormalize($array[0],Generation::class); form array to object entity

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

        $model = $this->modelRepository->findOneBy(['name' => $generation->getName()]);
        $body = $this->brandRepository->findOneBy(['name' => $model->getName()]);

        return $this->render('new_cars/selectAll.html.twig', [
            'brand' => $body,
            'model' => $model,
            'generation' => $generation,
            'body' => $body,
            'engine' => $engine,
            'now' => true
        ]);
    }

    // TODO : here is end
    #[Route('/year-ago/', name: 'new_cars_year_ago_generation')]
    public function carYearAgoChoosingGeneration(): Response
    {
        $generations = $this->generationRepository->getNewGenerationsYearAgo();

        $array = $this->normalizer->normalize($generations,null,['groups' => ['new_car']]); // to array

        //$json = $this->serializerInterface->serialize($generations,'json',['groups' => ['new_car']]);  // to json

        //$obj = $this->denormalizer->denormalize($array[0],Generation::class); form array to object entity

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

        $model = $this->modelRepository->findOneBy(['name' => $generation->getName()]);
        $body = $this->brandRepository->findOneBy(['name' => $model->getName()]);

        return $this->render('new_cars/selectAll.html.twig', [
            'brand' => $body,
            'model' => $model,
            'generation' => $generation,
            'body' => $body,
            'engine' => $engine
        ]);
    }
}
