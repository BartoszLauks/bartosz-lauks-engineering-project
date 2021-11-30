<?php

namespace App\Controller;

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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
        //$form = $this->formFactory->createNamed('test-name-form',ChoicesBrandType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $brand = $this->brandRepository->findOneBy(['id' => $request->request->get('choices_brand')['brand']]);
            return $this->redirect($request->getUri().$brand->getName());
        }
        return $this->render('/technical_data/index.html.twig',['form' => $form->createView()]);
    }
    #[Route('/{brand}/', name: 'technical_data_model')]
    public function choosingModel(Request $request)
    {
        //dd($this->brandRepository->findOneBy(['name' => $request->get('brand')])->getId());
        $form = $this->formFactory->create(ChoicesModelType::class,[],[
            'brand' => $this->brandRepository->findOneBy(['name' => $request->get('brand')])->getId()
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $model = $this->modelRepository->findOneBy(['id' => $request->request->get('choices_model')['model']]);
            return $this->redirect($request->getUri().$model->getName());
        }
        return $this->render('/technical_data/index.html.twig',['form' => $form->createView()]);
    }
    #[Route('/{brand}/{model}/', name: 'technical_data_generation')]
    public function choosingGeneration(Request $request)
    {
        $form = $this->formFactory->create(ChoicesGenerationType::class,[],[
            'model' => $this->modelRepository->findOneBy(['name' => $request->get('model')])->getId()
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $generation = $this->generationRepository->findOneBy(['id' => $request->request->get('choices_generation')['generation']]);
            return $this->redirect($request->getUri().$generation->getName());
        }
        return $this->render('/technical_data/index.html.twig',['form' => $form->createView()]);
    }
    #[Route('/{brand}/{model}/{generation}/', name: 'technical_data_body')]
    public function choosingBody(Request $request)
    {
        $form = $this->formFactory->create(ChoicesBodyType::class,[],[
            'generation' => $this->generationRepository->findOneBy(['name' => $request->get('generation')])->getId()
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $body = $this->carBodyRepository->findOneBy(['id' => $request->request->get('choices_body')['body']]);
            return $this->redirect($request->getUri().$body->getName());
        }
        return $this->render('/technical_data/index.html.twig',['form' => $form->createView()]);
    }
    #[Route('/{brand}/{model}/{generation}/{body}/', name: 'technical_data_engine')]
    public function choosingEngine(Request $request)
    {
        //dd($this->carBodyRepository->findOneBy(['name' => $request->get('body')])->getId());
        $form = $this->formFactory->create(ChoicesEngineType::class,[],[
            'body' => $this->carBodyRepository->findOneBy(['name' => $request->get('body')])->getId()
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $engine = $this->engineRepository->findOneBy(['id' => $request->request->get('choices_engine')['engine']]);
            return $this->redirect($request->getUri().$engine->getName());
        }
        return $this->render('/technical_data/index.html.twig',['form' => $form->createView()]);
    }
    #[Route('/{brand}/{model}/{generation}/{body}/{engine}/', name: 'technical_data_all')]
    public function allComponents(Request $request)
    {
        return $this->redirect($this->generateUrl('app_home'));
    }
}
