<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\CarBody;
use App\Entity\Engine;
use App\Entity\Generation;
use App\Entity\Model;
use App\Form\ChoicesBodyType;
use App\Form\ChoicesBrandType;
use App\Form\ChoicesEngineType;
use App\Form\ChoicesGenerationType;
use App\Form\ChoicesModelType;
use App\Repository\CarBodyRepository;
use App\Repository\EngineRepository;
use App\Repository\GenerationRepository;
use App\Repository\ModelRepository;
use App\Repository\SpecialistCommentRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('specialist-comment')]
#[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
class CarDataSpecialistController extends AbstractController
{
    private FormFactoryInterface $formFactory;
    private ModelRepository $modelRepository;
    private GenerationRepository $generationRepository;
    private CarBodyRepository $carBodyRepository;
    private EngineRepository $engineRepository;
    private SpecialistCommentRepository $specialistCommentRepository;

    public function __construct(
        FormFactoryInterface $formFactory,
        ModelRepository $modelRepository,
        GenerationRepository $generationRepository,
        CarBodyRepository $carBodyRepository,
        EngineRepository $engineRepository,
        SpecialistCommentRepository $specialistCommentRepository
    ) {
        $this->formFactory = $formFactory;
        $this->modelRepository = $modelRepository;
        $this->generationRepository = $generationRepository;
        $this->carBodyRepository = $carBodyRepository;
        $this->engineRepository = $engineRepository;
        $this->specialistCommentRepository = $specialistCommentRepository;
    }

    #[Route('/', name: 'car_specialist_brand')]
    public function choosingBrand(Request $request): RedirectResponse|Response
    {
        $form = $this->formFactory->create(ChoicesBrandType::class);

        $offset = max(0, $request->query->getInt('offset', 0));
        $comments = $this->specialistCommentRepository->getSpecialistComment($offset);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $brand = $form->getData()['brand'];
            return $this->redirect($this->generateUrl('car_specialist_model', ['brand' => $brand]));
        }
        return $this->render('/car_data_specialist/index.html.twig',[
            'form' => $form->createView(),
            'comments' => $comments,
            'previous' => $offset - SpecialistCommentRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($comments), $offset + SpecialistCommentRepository::PAGINATOR_PER_PAGE)
        ]);
    }

    #[Route('/{brand}/', name: 'car_specialist_model')]
    #[ParamConverter('brand', options: ['mapping' => ['brand' => 'name']])]
    public function choosingModel(Request $request,Brand $brand): RedirectResponse|Response
    {
        $model = $this->modelRepository->getModelWithBrandRelation($brand);
        if (empty($model)) {
            throw new NotFoundHttpException();
        }

        $offset = max(0, $request->query->getInt('offset', 0));
        $comments = $this->specialistCommentRepository->getSpecialistCommentByBrand($brand,$offset);

        $form = $this->formFactory->create(ChoicesModelType::class,[],[
            'model' => $model
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $model = $form->getData()['model'];

            return $this->redirect($this->generateUrl('car_specialist_generation',['brand' => $brand->getName(), 'model' => $model]));
        }
        return $this->render('/car_data_specialist/index.html.twig',[
            'form' => $form->createView(),
            'brand' => $brand->getName(),
            'comments' => $comments,
            'previous' => $offset - SpecialistCommentRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($comments), $offset + SpecialistCommentRepository::PAGINATOR_PER_PAGE)
        ]);
    }

    #[Route('/{brand}/{model}/', name: 'car_specialist_generation')]
    #[ParamConverter('brand', options: ['mapping' => ['brand' => 'name']])]
    #[ParamConverter('model', options: ['mapping' => ['model' => 'name']])]
    public function choosingGeneration(Request $request,Brand $brand,Model $model): RedirectResponse|Response
    {
        $generation = $this->generationRepository->getGenerationWithBrandModelRelation($brand,$model);
        if (empty($generation)) {
            throw new NotFoundHttpException();
        }
        $offset = max(0, $request->query->getInt('offset', 0));
        $comments = $this->specialistCommentRepository->getSpecialistCommentByModel($brand,$model,$offset);

        $form = $this->formFactory->create(ChoicesGenerationType::class,[],[
            'generation' => $generation
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $generation = $form->getData()['generation'];
            return $this->redirect($this->generateUrl('car_specialist_body',['brand' => $brand->getName(),
                'model' => $model->getName(), 'generation' => $generation]));
        }
        return $this->render('/car_data_specialist/index.html.twig',[
            'form' => $form->createView(),
            'brand' => $brand->getName(),
            'model' => $model->getName(),
            'comments' => $comments,
            'previous' => $offset - SpecialistCommentRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($comments), $offset + SpecialistCommentRepository::PAGINATOR_PER_PAGE)
        ]);
    }

    #[Route('/{brand}/{model}/{generation}/', name: 'car_specialist_body')]
    #[ParamConverter('brand', options: ['mapping' => ['brand' => 'name']])]
    #[ParamConverter('model', options: ['mapping' => ['model' => 'name']])]
    #[ParamConverter('generation', options: ['mapping' => ['generation' => 'name']])]
    public function choosingBody(Request $request, Brand $brand, Model $model, Generation $generation): RedirectResponse|Response
    {
        $body = $this->carBodyRepository->getCarBodyWithGenerationModelBrandRelation($brand,$model,$generation);
        if (empty($body)) {
            throw new NotFoundHttpException();
        }
        $offset = max(0, $request->query->getInt('offset', 0));
        $comments = $this->specialistCommentRepository->getSpecialistCommentByGeneration($brand,$model,$generation,$offset);

        $form = $this->formFactory->create(ChoicesBodyType::class,[],[
            'body' => $body,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $body = $form->getData()['body'];
            return $this->redirect($this->generateUrl('car_specialist_engine',['brand' => $brand->getName(),
                'model' => $model->getName(), 'generation' => $generation->getName(), 'body' => $body]));
        }
        return $this->render('/car_data_specialist/index.html.twig',[
            'form' => $form->createView(),
            'brand' => $brand->getName(),
            'model' => $model->getName(),
            'generation' => $generation->getName(),
            'comments' => $comments,
            'previous' => $offset - SpecialistCommentRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($comments), $offset + SpecialistCommentRepository::PAGINATOR_PER_PAGE)
        ]);
    }

    #[Route('/{brand}/{model}/{generation}/{body}/', name: 'car_specialist_engine')]
    #[ParamConverter('brand', options: ['mapping' => ['brand' => 'name']])]
    #[ParamConverter('model', options: ['mapping' => ['model' => 'name']])]
    #[ParamConverter('generation', options: ['mapping' => ['generation' => 'name']])]
    #[ParamConverter('body', options: ['mapping' => ['body' => 'name']])]
    public function choosingEngine(Request $request,Brand $brand,Model $model,Generation $generation,CarBody $body): RedirectResponse|Response
    {
        $engine = $this->engineRepository->getEngineWithCarBodyGenerationBrandModelRelation($brand,$model,$generation,$body);
        if (empty($engine)) {
            throw new NotFoundHttpException();
        }
        $offset = max(0, $request->query->getInt('offset', 0));
        $comments = $this->specialistCommentRepository->getSpecialistCommentByCarBody($brand,$model,$generation,$body,$offset);

        $form = $this->formFactory->create(ChoicesEngineType::class,[],[
            'engine' => $engine
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $engine = $form->getData()['engine'];
            return $this->redirect($this->generateUrl('car_specialist_all',['brand' => $brand->getName(),
                'model' => $model->getName(), 'generation' => $generation->getName(), 'body' => $body->getName(),
                'engine' => $engine]));
        }
        return $this->render('/car_data_specialist/index.html.twig',[
            'form' => $form->createView(),
            'brand' => $brand->getName(),
            'model' => $model->getName(),
            'generation' => $generation->getName(),
            'body' => $body->getName(),
            'comments' => $comments,
            'previous' => $offset - SpecialistCommentRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($comments), $offset + SpecialistCommentRepository::PAGINATOR_PER_PAGE)
        ]);
    }

    #[Route('/{brand}/{model}/{generation}/{body}/{engine}/', name: 'car_specialist_all')]
    #[ParamConverter('brand', options: ['mapping' => ['brand' => 'name']])]
    #[ParamConverter('model', options: ['mapping' => ['model' => 'name']])]
    #[ParamConverter('generation', options: ['mapping' => ['generation' => 'name']])]
    #[ParamConverter('body', options: ['mapping' => ['body' => 'name']])]
    #[ParamConverter('engine', options: ['mapping' => ['engine' => 'name']])]
    public function allComponents(Request $request,Brand $brand,Model $model,Generation $generation,CarBody $body, Engine $engine): Response
    {
        $components = $this->engineRepository->checkCarExist($brand,$model,$generation,$body,$engine);
        if (empty($components))
        {
            throw new NotFoundHttpException();
        }
        $offset = max(0, $request->query->getInt('offset', 0));
        $comments = $this->specialistCommentRepository->getSpecialistCommentByEngine($brand,$model,$generation,$body,$engine,$offset);

        return $this->render('/car_data_specialist/index.html.twig',[
            'brand' => $brand->getName(),
            'model' => $model->getName(),
            'generation' => $generation->getName(),
            'body' => $body->getName(),
            'engine' => $engine->getName(),
            'comments' => $comments,
            'previous' => $offset - SpecialistCommentRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($comments), $offset + SpecialistCommentRepository::PAGINATOR_PER_PAGE)
        ]);
    }
}
