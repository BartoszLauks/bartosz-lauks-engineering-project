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
use App\Repository\BrandRepository;
use App\Repository\CarBodyRepository;
use App\Repository\EngineRepository;
use App\Repository\GenerationRepository;
use App\Repository\ModelRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/technical-data')]
class TechnicalDataController extends AbstractController
{
    private $formFactory;
    private $brandRepository;
    private $modelRepository;
    private $generationRepository;
    private $carBodyRepository;
    private $engineRepository;

    public function __construct(
        FormFactoryInterface $formFactory,
        BrandRepository $brandRepository,
        ModelRepository $modelRepository,
        GenerationRepository $generationRepository,
        CarBodyRepository $carBodyRepository,
        EngineRepository $engineRepository,


    ) {
        $this->formFactory = $formFactory;
        $this->brandRepository = $brandRepository;
        $this->modelRepository = $modelRepository;
        $this->generationRepository = $generationRepository;
        $this->carBodyRepository = $carBodyRepository;
        $this->engineRepository = $engineRepository;
    }

    #[Route('/', name: 'technical_data_brand')]
    public function choosingBrand(Request $request)
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
    public function choosingModel(Request $request,Brand $brand)
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
        return $this->render('/technical_data/index.html.twig',['form' => $form->createView()]);
    }
    #[Route('/{brand}/{model}/', name: 'technical_data_generation')]
    #[ParamConverter('brand', options: ['mapping' => ['brand' => 'name']])]
    #[ParamConverter('model', options: ['mapping' => ['model' => 'name']])]
    public function choosingGeneration(Request $request,Brand $brand,Model $model)
    {
        $generation = $this->generationRepository->getGenerationWithBrandModelRelation($brand,$model);
        if (empty($generation)) {
            throw new NotFoundHttpException();
        }
        $form = $this->formFactory->create(ChoicesGenerationType::class,[],[
            //'model' => $this->modelRepository->findOneBy(['name' => $request->get('model')])->getId()
            'generation' => $generation
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            //$generation = $this->generationRepository->findOneBy(['id' => $request->request->get('choices_generation')['generation']]);
            //dd($this->carBodyRepository->getCarBodyWithGenerationBrandModelRelation($brand,$model,$form->getData()['generation'])->getQuery()->getResult());
            $generation = $form->getData()['generation'];
            return $this->redirect($request->getUri().$generation);
        }
        return $this->render('/technical_data/index.html.twig',['form' => $form->createView()]);
    }
    #[Route('/{brand}/{model}/{generation}/', name: 'technical_data_body')]
    #[ParamConverter('brand', options: ['mapping' => ['brand' => 'name']])]
    #[ParamConverter('model', options: ['mapping' => ['model' => 'name']])]
    #[ParamConverter('generation', options: ['mapping' => ['generation' => 'name']])]
    public function choosingBody(Request $request, Brand $brand, Model $model, Generation $generation)
    {
        $body = $this->carBodyRepository->getCarBodyWithGenerationModelBrandRelation($brand,$model,$generation);
        if (empty($body)) {
            throw new NotFoundHttpException();
        }
        $form = $this->formFactory->create(ChoicesBodyType::class,[],[
            //'generation' => $this->generationRepository->findOneBy(['name' => $request->get('generation')])->getId()
            'body' => $body,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            //dd($form->getData());
            //$body = $this->carBodyRepository->findOneBy(['id' => $request->request->get('choices_body')['body']]);
            $body = $form->getData()['body'];
            return $this->redirect($request->getUri().$body);
        }
        return $this->render('/technical_data/index.html.twig',['form' => $form->createView()]);
    }
    #[Route('/{brand}/{model}/{generation}/{body}/', name: 'technical_data_engine')]
    #[ParamConverter('brand', options: ['mapping' => ['brand' => 'name']])]
    #[ParamConverter('model', options: ['mapping' => ['model' => 'name']])]
    #[ParamConverter('generation', options: ['mapping' => ['generation' => 'name']])]
    #[ParamConverter('body', options: ['mapping' => ['body' => 'name']])]
    public function choosingEngine(Request $request,Brand $brand,Model $model,Generation $generation,CarBody $body)
    {
        //dd($this->carBodyRepository->findOneBy(['name' => $request->get('body')])->getId());
        $engine = $this->engineRepository->getEngineWithCarBodyGenerationBrandModelRelation($brand,$model,$generation,$body);
        //dd($engine);
        if (empty($engine)) {
            throw new NotFoundHttpException();
        }
        $form = $this->formFactory->create(ChoicesEngineType::class,[],[
            'engine' => $engine
            //'body' => $this->carBodyRepository->findOneBy(['name' => $request->get('body')])->getId()
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $engine = $form->getData()['engine'];
            //$engine = $this->engineRepository->findOneBy(['id' => $request->request->get('choices_engine')['engine']]);
            return $this->redirect($request->getUri().$engine);
        }
        return $this->render('/technical_data/index.html.twig',['form' => $form->createView()]);
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
        dd($components);
        return $this->redirect($this->generateUrl('app_home'));
    }
}
