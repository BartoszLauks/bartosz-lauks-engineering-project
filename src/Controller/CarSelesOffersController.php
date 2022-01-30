<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\CarBody;
use App\Entity\Engine;
use App\Entity\Generation;
use App\Entity\Model;
use App\Entity\SalesOffers;
use App\Form\ChoicesBodyType;
use App\Form\ChoicesBrandType;
use App\Form\ChoicesEngineType;
use App\Form\ChoicesGenerationType;
use App\Form\ChoicesModelType;
use App\Form\NewOfferType;
use App\Repository\CarBodyRepository;
use App\Repository\EngineRepository;
use App\Repository\GenerationRepository;
use App\Repository\ModelRepository;
use App\Repository\SalesOffersRepository;
use App\Repository\SpecialistCommentRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/seles-offers')]
#[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
class CarSelesOffersController extends AbstractController
{
    private FormFactoryInterface $formFactory;
    private ModelRepository $modelRepository;
    private GenerationRepository $generationRepository;
    private CarBodyRepository $carBodyRepository;
    private EngineRepository $engineRepository;
    private ParameterBagInterface $parameterBag;
    private Security $security;
    private UserRepository $userRepository;
    private EntityManagerInterface $entityManager;
    private SalesOffersRepository $offersRepository;


    public function __construct(
        FormFactoryInterface $formFactory,
        ModelRepository $modelRepository,
        GenerationRepository $generationRepository,
        CarBodyRepository $carBodyRepository,
        EngineRepository $engineRepository,
        ParameterBagInterface $parameterBag,
        Security $security,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        SalesOffersRepository $offersRepository
    ) {
        $this->formFactory = $formFactory;
        $this->modelRepository = $modelRepository;
        $this->generationRepository = $generationRepository;
        $this->carBodyRepository = $carBodyRepository;
        $this->engineRepository = $engineRepository;
        $this->parameterBag = $parameterBag;
        $this->security = $security;
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->offersRepository = $offersRepository;
    }

    #[Route('/', name: 'car_seles_offers_brand')]
    public function choosingBrand(Request $request): Response
    {
        $form = $this->formFactory->create(ChoicesBrandType::class);
        $form->handleRequest($request);

        $offset = max(0, $request->query->getInt('offset', 0));
        $offers = $this->offersRepository->getOffers($offset);

        if ($form->isSubmitted())
        {
            $brand = $form->getData()['brand'];

            return $this->redirect($this->generateUrl('car_seles_offers_model',['brand' => $brand]));
        }
        return $this->render('/car_seles_offers/index.html.twig',[
            'form' => $form->createView(),
            'offers' => $offers,
            'previous' => $offset - SalesOffersRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($offers), $offset + SalesOffersRepository::PAGINATOR_PER_PAGE)

        ]);
    }

    #[Route('/{brand}/', name: 'car_seles_offers_model')]
    #[ParamConverter('brand', options: ['mapping' => ['brand' => 'name']])]
    public function choosingModel(Request $request,Brand $brand): RedirectResponse|Response
    {
        $model = $this->modelRepository->getModelWithBrandRelation($brand);
        if (empty($model)) {
            throw new NotFoundHttpException();
        }
        $offset = max(0, $request->query->getInt('offset', 0));
        $offers = $this->offersRepository->getOffersByBrand($brand,$offset);

        $form = $this->formFactory->create(ChoicesModelType::class,[],[
            'model' => $model
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $model = $form->getData()['model'];

            return $this->redirect($this->generateUrl('car_seles_offers_generation',['brand' => $brand->getName(),
                'model' => $model]));
        }
        return $this->render('/car_seles_offers/index.html.twig',[
            'brand' => $brand->getName(),
            'form' => $form->createView(),
            'offers' => $offers,
            'previous' => $offset - SalesOffersRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($offers), $offset + SalesOffersRepository::PAGINATOR_PER_PAGE)
        ]);
    }

    #[Route('/{brand}/{model}/', name: 'car_seles_offers_generation')]
    #[ParamConverter('brand', options: ['mapping' => ['brand' => 'name']])]
    #[ParamConverter('model', options: ['mapping' => ['model' => 'name']])]
    public function choosingGeneration(Request $request,Brand $brand,Model $model): RedirectResponse|Response
    {
        $generation = $this->generationRepository->getGenerationWithBrandModelRelation($brand,$model);
        if (empty($generation)) {
            throw new NotFoundHttpException();
        }
        $offset = max(0, $request->query->getInt('offset', 0));
        $offers = $this->offersRepository->getOffersByModel($brand,$model,$offset);

        $form = $this->formFactory->create(ChoicesGenerationType::class,[],[
            'generation' => $generation
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $generation = $form->getData()['generation'];
            return $this->redirect($this->generateUrl('car_seles_offers_body',['brand' => $brand->getName(),
                'model' => $model->getName(), 'generation' => $generation]));
        }
        return $this->render('/car_seles_offers/index.html.twig',[
            'brand' => $brand->getName(),
            'model' => $model->getName(),
            'form' => $form->createView(),
            'offers' => $offers,
            'previous' => $offset - SalesOffersRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($offers), $offset + SalesOffersRepository::PAGINATOR_PER_PAGE)
        ]);
    }

    #[Route('/{brand}/{model}/{generation}/', name: 'car_seles_offers_body')]
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
        $offers = $this->offersRepository->getOffersByGeneration($brand,$model,$generation,$offset);

        $form = $this->formFactory->create(ChoicesBodyType::class,[],[
            'body' => $body,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $body = $form->getData()['body'];
            return $this->redirect($this->generateUrl('car_seles_offers_engine',['brand' => $brand->getName(),
                'model' => $model->getName(), 'generation' => $generation->getName(), 'body' => $body]));
        }
        return $this->render('/car_seles_offers/index.html.twig',[
            'brand' => $brand->getName(),
            'model' => $model->getName(),
            'generation' => $generation->getName(),
            'form' => $form->createView(),
            'offers' => $offers,
            'previous' => $offset - SalesOffersRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($offers), $offset + SalesOffersRepository::PAGINATOR_PER_PAGE)
        ]);
    }

    #[Route('/{brand}/{model}/{generation}/{body}/', name: 'car_seles_offers_engine')]
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
        $offers = $this->offersRepository->getOffersByCarBody($brand,$model,$generation,$body,$offset);

        $form = $this->formFactory->create(ChoicesEngineType::class,[],[
            'engine' => $engine
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $engine = $form->getData()['engine'];
            return $this->redirect($this->generateUrl('car_seles_offers_all',['brand' => $brand->getName(),
                'model' => $model->getName(), 'generation' => $generation->getName(), 'body' => $body->getName(), 'engine' => $engine]));
        }
        return $this->render('/car_seles_offers/index.html.twig',[
            'brand' => $brand->getName(),
            'model' => $model->getName(),
            'generation' => $generation->getName(),
            'body' => $body->getName(),
            'form' => $form->createView(),
            'offers' => $offers,
            'previous' => $offset - SalesOffersRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($offers), $offset + SalesOffersRepository::PAGINATOR_PER_PAGE)
        ]);
    }

    #[Route('/{brand}/{model}/{generation}/{body}/{engine}/', name: 'car_seles_offers_all')]
    #[ParamConverter('brand', options: ['mapping' => ['brand' => 'name']])]
    #[ParamConverter('model', options: ['mapping' => ['model' => 'name']])]
    #[ParamConverter('generation', options: ['mapping' => ['generation' => 'name']])]
    #[ParamConverter('body', options: ['mapping' => ['body' => 'name']])]
    #[ParamConverter('engine', options: ['mapping' => ['engine' => 'name']])]
    public function allComponents(Request $request, Brand $brand,Model $model,Generation $generation,CarBody $body, Engine $engine): Response
    {
        $components = $this->engineRepository->checkCarExist($brand,$model,$generation,$body,$engine);
        if (empty($components))
        {
            throw new NotFoundHttpException();
        }
        $offset = max(0, $request->query->getInt('offset', 0));
        $offers = $this->offersRepository->getOffersByEngine($brand,$model,$generation,$body,$engine,$offset);

        return $this->render('/car_seles_offers/index.html.twig',[
            'brand' => $brand->getName(),
            'model' => $model->getName(),
            'generation' => $generation->getName(),
            'body' => $body->getName(),
            'engine' => $engine->getName(),
            'offers' => $offers,
            'new' => true,
            'previous' => $offset - SalesOffersRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($offers), $offset + SalesOffersRepository::PAGINATOR_PER_PAGE)
        ]);
    }

    #[Route('/{brand}/{model}/{generation}/{body}/{engine}/new', name: 'car_seles_offers_new')]
    #[ParamConverter('brand', options: ['mapping' => ['brand' => 'name']])]
    #[ParamConverter('model', options: ['mapping' => ['model' => 'name']])]
    #[ParamConverter('generation', options: ['mapping' => ['generation' => 'name']])]
    #[ParamConverter('body', options: ['mapping' => ['body' => 'name']])]
    #[ParamConverter('engine', options: ['mapping' => ['engine' => 'name']])]
    public function newOffert(Request $request,Brand $brand,Model $model,Generation $generation,CarBody $body, Engine $engine): RedirectResponse|Response
    {
        $components = $this->engineRepository->checkCarExist($brand,$model,$generation,$body,$engine);
        if (empty($components))
        {
            throw new NotFoundHttpException();
        }

        $offer = new SalesOffers();
        $form = $this->formFactory->create(NewOfferType::class,$offer);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            $offer = $form->getData();
            $file = ($request->files->get('new_offer')['file']);

            if ($file)
            {
                $filename = md5(uniqid()).".". $file->guessClientExtension();
                $file->move($this->parameterBag->get('uploads_dir_offer'),$filename);

                $offer->setFile($filename);
            }

            $offer->setBrand($brand);
            $offer->setModel($model);
            $offer->setGeneration($generation);
            $offer->setCarBody($body);
            $offer->setEngine($engine);
            $offer->setUser($this->userRepository->find($this->security->getUser()));

            $this->entityManager->persist($offer);
            $this->entityManager->flush();

            $this->addFlash('success',"Your offer was added");

            return $this->redirectToRoute('car_seles_offers_all',[
                'brand' => $brand,
                'model' => $model,
                'generation' => $generation,
                'body' => $body,
                'engine' => $engine
            ]);
        }

        return $this->render('/car_seles_offers/new.html.twig',[
            'form' => $form->createView()
        ]);
    }

    #[Route('/{brand}/{model}/{generation}/{body}/{engine}/offer/{offer}/show', name: 'car_seles_offers_show')]
    #[ParamConverter('brand', options: ['mapping' => ['brand' => 'name']])]
    #[ParamConverter('model', options: ['mapping' => ['model' => 'name']])]
    #[ParamConverter('generation', options: ['mapping' => ['generation' => 'name']])]
    #[ParamConverter('body', options: ['mapping' => ['body' => 'name']])]
    #[ParamConverter('engine', options: ['mapping' => ['engine' => 'name']])]
    #[ParamConverter('offer')]
    public function showOffer(Brand $brand,Model $model,Generation $generation,CarBody $body, Engine $engine, SalesOffers $offer): Response
    {
        return $this->render('/car_seles_offers/show.html.twig',[
            'brand' => $brand,
            'model' => $model,
            'generation' => $generation,
            'body' => $body,
            'engine' => $engine,
            'offer' => $offer
        ]);
    }
    #[Route('/{brand}/{model}/{generation}/{body}/{engine}/offer/{offer}/remove', name: 'car_seles_offers_remove')]
    #[ParamConverter('brand', options: ['mapping' => ['brand' => 'name']])]
    #[ParamConverter('model', options: ['mapping' => ['model' => 'name']])]
    #[ParamConverter('generation', options: ['mapping' => ['generation' => 'name']])]
    #[ParamConverter('body', options: ['mapping' => ['body' => 'name']])]
    #[ParamConverter('engine', options: ['mapping' => ['engine' => 'name']])]
    #[ParamConverter('offer')]
    public function removeOffer(Brand $brand,Model $model,Generation $generation,CarBody $body, Engine $engine, SalesOffers $offer): RedirectResponse
    {
        if ($this->security->getUser() !== $offer->getUser())
        {
            $this->addFlash('danger',"Access denied. This is not your offer");

            return $this->redirect($this->generateUrl('car_seles_offers_all',[
                'brand' => $brand,
                'model' => $model,
                'generation' => $generation,
                'body' => $body,
                'engine' => $engine,
                'offer' => $offer
            ]));
        }

        $this->entityManager->remove($offer);
        $this->entityManager->flush();

        $this->addFlash('success',"Your post was remove");

        return $this->redirect($this->generateUrl('car_seles_offers_all',[
            'brand' => $brand,
            'model' => $model,
            'generation' => $generation,
            'body' => $body,
            'engine' => $engine,
            'offer' => $offer
        ]));
    }

    #[Route('-user/', name: 'car_seles_offers_user')]
    public function userOffers(Request $request): Response
    {
        $offset = max(0, $request->query->getInt('offset', 0));
        $offers = $this->offersRepository->getUserOffers($offset);

        return $this->render('/car_seles_offers/userOffers.html.twig',[
            'offers' => $offers,
            'previous' => $offset - SalesOffersRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($offers), $offset + SalesOffersRepository::PAGINATOR_PER_PAGE)
        ]);
    }

    #[Route('-user/offer/{offer}/remove', name: 'car_seles_offers_user_remove')]
    #[ParamConverter('offer')]
    public function userOfferRemove(SalesOffers $offer): RedirectResponse
    {
        if ($this->security->getUser() !== $offer->getUser())
        {
            $this->addFlash('danger', "Access denied. This is not your offer");

            return $this->redirect($this->generateUrl('car_seles_offers_user'));
        }

        $this->entityManager->remove($offer);
        $this->entityManager->flush();

        $this->addFlash('success',"Your offert was remove");

        return $this->redirect($this->generateUrl('car_seles_offers_user'));
    }
}
