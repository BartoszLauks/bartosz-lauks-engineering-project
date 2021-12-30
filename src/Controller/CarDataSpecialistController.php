<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\CarBody;
use App\Entity\Engine;
use App\Entity\Generation;
use App\Entity\Model;
use App\Entity\SpecialistComment;
use App\Form\ChoicesBodyType;
use App\Form\ChoicesBrandType;
use App\Form\ChoicesEngineType;
use App\Form\ChoicesGenerationType;
use App\Form\ChoicesModelType;
use App\Repository\BrandRepository;
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
    private $formFactory;
    private $brandRepository;
    private $modelRepository;
    private $generationRepository;
    private $carBodyRepository;
    private $engineRepository;
    private $specialistCommentRepository;

    public function __construct(
        FormFactoryInterface $formFactory,
        BrandRepository $brandRepository,
        ModelRepository $modelRepository,
        GenerationRepository $generationRepository,
        CarBodyRepository $carBodyRepository,
        EngineRepository $engineRepository,
        SpecialistCommentRepository $specialistCommentRepository
    ) {
        $this->formFactory = $formFactory;
        $this->brandRepository = $brandRepository;
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

        $comments = $this->specialistCommentRepository->getSpecialistComment();

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $brand = $form->getData()['brand'];
            return $this->redirect($request->getUri().$brand->getName());
        }
        return $this->render('/car_data_specialist/index.html.twig',[
            'form' => $form->createView(),
            'comments' => $comments
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
        $comments = $this->specialistCommentRepository->getSpecialistCommentByBrand($brand);

        $form = $this->formFactory->create(ChoicesModelType::class,[],[
            'model' => $model
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $model = $form->getData()['model'];

            return $this->redirect($request->getUri().$model);
        }
        return $this->render('/car_data_specialist/index.html.twig',[
            'form' => $form->createView(),
            'brand' => $brand->getName(),
            'comments' => $comments
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
        $comments = $this->specialistCommentRepository->getSpecialistCommentByModel($brand,$model);

        $form = $this->formFactory->create(ChoicesGenerationType::class,[],[
            'generation' => $generation
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $generation = $form->getData()['generation'];
            return $this->redirect($request->getUri().$generation);
        }
        return $this->render('/car_data_specialist/index.html.twig',[
            'form' => $form->createView(),
            'brand' => $brand->getName(),
            'model' => $model->getName(),
            'comments' => $comments
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
        $comments = $this->specialistCommentRepository->getSpecialistCommentByGeneration($brand,$model,$generation);

        $form = $this->formFactory->create(ChoicesBodyType::class,[],[
            'body' => $body,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $body = $form->getData()['body'];
            return $this->redirect($request->getUri().$body);
        }
        return $this->render('/car_data_specialist/index.html.twig',[
            'form' => $form->createView(),
            'brand' => $brand->getName(),
            'model' => $model->getName(),
            'generation' => $generation->getName(),
            'comments' => $comments
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
        $comments = $this->specialistCommentRepository->getSpecialistCommentByCarBody($brand,$model,$generation,$body);

        $form = $this->formFactory->create(ChoicesEngineType::class,[],[
            'engine' => $engine
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $engine = $form->getData()['engine'];
            return $this->redirect($request->getUri().$engine);
        }
        return $this->render('/car_data_specialist/index.html.twig',[
            'form' => $form->createView(),
            'brand' => $brand->getName(),
            'model' => $model->getName(),
            'generation' => $generation->getName(),
            'body' => $body->getName(),
            'comments' => $comments
        ]);
    }

    #[Route('/{brand}/{model}/{generation}/{body}/{engine}/', name: 'car_specialist_all')]
    #[ParamConverter('brand', options: ['mapping' => ['brand' => 'name']])]
    #[ParamConverter('model', options: ['mapping' => ['model' => 'name']])]
    #[ParamConverter('generation', options: ['mapping' => ['generation' => 'name']])]
    #[ParamConverter('body', options: ['mapping' => ['body' => 'name']])]
    #[ParamConverter('engine', options: ['mapping' => ['engine' => 'name']])]
    public function allComponents(Request $request,Brand $brand,Model $model,Generation $generation,CarBody $body, Engine $engine)
    {
        $components = $this->engineRepository->checkCarExist($brand,$model,$generation,$body,$engine);
        if (empty($components))
        {
            throw new NotFoundHttpException();
        }
        $comments = $this->specialistCommentRepository->getSpecialistCommentByEngine($brand,$model,$generation,$body,$engine);

        return $this->render('/car_data_specialist/index.html.twig',[
            'brand' => $brand->getName(),
            'model' => $model->getName(),
            'generation' => $generation->getName(),
            'body' => $body->getName(),
            'engine' => $engine->getName(),
            'comments' => $comments
        ]);
    }
}
