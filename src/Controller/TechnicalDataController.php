<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\CarBody;
use App\Entity\CarBodyValue;
use App\Entity\Engine;
use App\Entity\Generation;
use App\Entity\Model;
use App\Form\ChoicesBodyType;
use App\Form\ChoicesBrandType;
use App\Form\ChoicesEngineType;
use App\Form\ChoicesGenerationType;
use App\Form\ChoicesModelType;
use App\Repository\BrandRepository;
use App\Repository\CarBodyRepository;
use App\Repository\CarBodyValueRepository;
use App\Repository\EngineRepository;
use App\Repository\EngineValueRepository;
use App\Repository\GenerationRepository;
use App\Repository\ModelRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/technical-data')]
#[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
class TechnicalDataController extends AbstractController
{
    private $formFactory;
    private $brandRepository;
    private $modelRepository;
    private $generationRepository;
    private $carBodyRepository;
    private $engineRepository;
    private $carBodyValueRepository;
    private $engineValueRepository;

    public function __construct(
        FormFactoryInterface $formFactory,
        BrandRepository $brandRepository,
        ModelRepository $modelRepository,
        GenerationRepository $generationRepository,
        CarBodyRepository $carBodyRepository,
        EngineRepository $engineRepository,
        CarBodyValueRepository $carBodyValueRepository,
        EngineValueRepository $engineValueRepository

    ) {
        $this->formFactory = $formFactory;
        $this->brandRepository = $brandRepository;
        $this->modelRepository = $modelRepository;
        $this->generationRepository = $generationRepository;
        $this->carBodyRepository = $carBodyRepository;
        $this->engineRepository = $engineRepository;
        $this->carBodyValueRepository = $carBodyValueRepository;
        $this->engineValueRepository = $engineValueRepository;
    }

    #[Route('/', name: 'technical_data_brand')]
    public function choosingBrand(Request $request): RedirectResponse|Response
    {

        $form = $this->formFactory->create(ChoicesBrandType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $brand = $form->getData()['brand'];
            return $this->redirect($request->getUri().$brand->getName());
        }
        return $this->render('/technical_data/index.html.twig',['form' => $form->createView()]);
    }

    #[Route('/{brand}/', name: 'technical_data_model')]
    #[ParamConverter('brand', options: ['mapping' => ['brand' => 'name']])]
    public function choosingModel(Request $request,Brand $brand): RedirectResponse|Response
    {
        $model = $this->modelRepository->getModelWithBrandRelation($brand);
        if (empty($model)) {
            throw new NotFoundHttpException();
        }
        $form = $this->formFactory->create(ChoicesModelType::class,[],[
            'model' => $model
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $model = $form->getData()['model'];

            return $this->redirect($request->getUri().$model);
        }
        return $this->render('/technical_data/index.html.twig',[
            'form' => $form->createView(),
            'brand' => $brand->getName()
        ]);
    }

    #[Route('/{brand}/{model}/', name: 'technical_data_generation')]
    #[ParamConverter('brand', options: ['mapping' => ['brand' => 'name']])]
    #[ParamConverter('model', options: ['mapping' => ['model' => 'name']])]
    public function choosingGeneration(Request $request,Brand $brand,Model $model): RedirectResponse|Response
    {
        $generation = $this->generationRepository->getGenerationWithBrandModelRelation($brand,$model);
        if (empty($generation)) {
            throw new NotFoundHttpException();
        }
        $form = $this->formFactory->create(ChoicesGenerationType::class,[],[
            'generation' => $generation
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $generation = $form->getData()['generation'];
            return $this->redirect($request->getUri().$generation);
        }
        return $this->render('/technical_data/index.html.twig',[
            'form' => $form->createView(),
            'brand' => $brand->getName(),
            'model' => $model->getName()
        ]);
    }

    #[Route('/{brand}/{model}/{generation}/', name: 'technical_data_body')]
    #[ParamConverter('brand', options: ['mapping' => ['brand' => 'name']])]
    #[ParamConverter('model', options: ['mapping' => ['model' => 'name']])]
    #[ParamConverter('generation', options: ['mapping' => ['generation' => 'name']])]
    public function choosingBody(Request $request, Brand $brand, Model $model, Generation $generation): RedirectResponse|Response
    {
        $body = $this->carBodyRepository->getCarBodyWithGenerationModelBrandRelation($brand,$model,$generation);
        if (empty($body)) {
            throw new NotFoundHttpException();
        }
        $form = $this->formFactory->create(ChoicesBodyType::class,[],[
            'body' => $body,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $body = $form->getData()['body'];
            return $this->redirect($request->getUri().$body);
        }
        return $this->render('/technical_data/index.html.twig',[
            'form' => $form->createView(),
            'brand' => $brand->getName(),
            'model' => $model->getName(),
            'generation' => $generation->getName()
        ]);
    }

    #[Route('/{brand}/{model}/{generation}/{body}/', name: 'technical_data_engine')]
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
        $form = $this->formFactory->create(ChoicesEngineType::class,[],[
            'engine' => $engine
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $engine = $form->getData()['engine'];
            return $this->redirect($request->getUri().$engine);
        }
        return $this->render('/technical_data/index.html.twig',[
            'form' => $form->createView(),
            'brand' => $brand->getName(),
            'model' => $model->getName(),
            'generation' => $generation->getName(),
            'body' => $body->getName()
        ]);
    }

    #[Route('/{brand}/{model}/{generation}/{body}/{engine}/', name: 'technical_data_all')]
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

        $bodyValue = $this->carBodyValueRepository->findBy(['carBody' => $body]);
        $engineValue = $this->engineValueRepository->findBy(['engine' => $engine]);

        return $this->render('/technical_data/show.html.twig',[
            'brand' => $brand,
            'model' => $model,
            'generation' => $generation,
            'body' => $body,
            'engine' => $engine,
            'bodyValues' => $bodyValue,
            'engineValues' => $engineValue
        ]);
    }
}
