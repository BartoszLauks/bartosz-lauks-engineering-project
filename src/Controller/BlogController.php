<?php

namespace App\Controller;

use App\Entity\Brand;
use App\Entity\CarBody;
use App\Entity\Comment;
use App\Entity\Engine;
use App\Entity\Generation;
use App\Entity\Model;
use App\Entity\Post;
use App\Form\ChoicesBodyType;
use App\Form\ChoicesBrandType;
use App\Form\ChoicesEngineType;
use App\Form\ChoicesGenerationType;
use App\Form\ChoicesModelType;
use App\Form\PostType;
use App\Repository\CarBodyRepository;
use App\Repository\CommentRepository;
use App\Repository\EngineRepository;
use App\Repository\GenerationRepository;
use App\Repository\ModelRepository;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

#[Route('/blog')]
#[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
class BlogController extends AbstractController
{
    private FormFactoryInterface $formFactory;
    private ModelRepository $modelRepository;
    private GenerationRepository $generationRepository;
    private CarBodyRepository $carBodyRepository;
    private EngineRepository $engineRepository;
    private Security $security;
    private UserRepository $userRepository;
    private EntityManagerInterface $entityManager;
    private PostRepository $postRepository;
    private CommentRepository $commentRepository;


    public function __construct(
        FormFactoryInterface $formFactory,
        ModelRepository $modelRepository,
        GenerationRepository $generationRepository,
        CarBodyRepository $carBodyRepository,
        EngineRepository $engineRepository,
        Security $security,
        UserRepository $userRepository,
        EntityManagerInterface $entityManager,
        PostRepository $postRepository,
        CommentRepository $commentRepository
    ) {
        $this->formFactory = $formFactory;
        $this->modelRepository = $modelRepository;
        $this->generationRepository = $generationRepository;
        $this->carBodyRepository = $carBodyRepository;
        $this->engineRepository = $engineRepository;
        $this->security = $security;
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
        $this->postRepository = $postRepository;
        $this->commentRepository = $commentRepository;
    }

    #[Route('/', name: 'blog_brand')]
    public function choosingBrand(Request $request): RedirectResponse|Response
    {
        $form = $this->formFactory->create(ChoicesBrandType::class);

        $form->handleRequest($request);

        $posts = $this->postRepository->getPosts();
        if ($form->isSubmitted())
        {
            $brand = $form->getData()['brand'];
            return $this->redirect($request->getUri().$brand->getName());
        }
        return $this->render('/blog/index.html.twig',[
            'form' => $form->createView(),
            'posts' => $posts
        ]);
    }

    #[Route('/{brand}/', name: 'blog_model')]
    #[ParamConverter('brand', options: ['mapping' => ['brand' => 'name']])]
    public function choosingModel(Request $request,Brand $brand): RedirectResponse|Response
    {
        $model = $this->modelRepository->getModelWithBrandRelation($brand);
        if (empty($model)) {
            throw new NotFoundHttpException();
        }
        $posts = $this->postRepository->getPostsByBrand($brand);

        $form = $this->formFactory->create(ChoicesModelType::class,[],[
            'model' => $model
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $model = $form->getData()['model'];

            return $this->redirect($request->getUri().$model);
        }
        return $this->render('/blog/index.html.twig',[
            'brand' => $brand->getName(),
            'form' => $form->createView(),
            'posts' => $posts
        ]);
    }

    #[Route('/{brand}/{model}/', name: 'blog_generation')]
    #[ParamConverter('brand', options: ['mapping' => ['brand' => 'name']])]
    #[ParamConverter('model', options: ['mapping' => ['model' => 'name']])]
    public function choosingGeneration(Request $request,Brand $brand,Model $model): RedirectResponse|Response
    {
        $generation = $this->generationRepository->getGenerationWithBrandModelRelation($brand,$model);
        if (empty($generation)) {
            throw new NotFoundHttpException();
        }
        $posts = $this->postRepository->getPostsByModel($brand,$model);

        $form = $this->formFactory->create(ChoicesGenerationType::class,[],[
            'generation' => $generation
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $generation = $form->getData()['generation'];
            return $this->redirect($request->getUri().$generation);
        }
        return $this->render('/blog/index.html.twig',[
            'brand' => $brand->getName(),
            'model' => $model->getName(),
            'form' => $form->createView(),
            'posts' => $posts
        ]);
    }

    #[Route('/{brand}/{model}/{generation}/', name: 'blog_body')]
    #[ParamConverter('brand', options: ['mapping' => ['brand' => 'name']])]
    #[ParamConverter('model', options: ['mapping' => ['model' => 'name']])]
    #[ParamConverter('generation', options: ['mapping' => ['generation' => 'name']])]
    public function choosingBody(Request $request, Brand $brand, Model $model, Generation $generation): RedirectResponse|Response
    {
        $body = $this->carBodyRepository->getCarBodyWithGenerationModelBrandRelation($brand,$model,$generation);
        if (empty($body)) {
            throw new NotFoundHttpException();
        }
        $posts = $this->postRepository->getPostsByGeneration($brand,$model,$generation);

        $form = $this->formFactory->create(ChoicesBodyType::class,[],[
            'body' => $body,
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $body = $form->getData()['body'];
            return $this->redirect($request->getUri().$body);
        }
        return $this->render('/blog/index.html.twig',[
            'brand' => $brand->getName(),
            'model' => $model->getName(),
            'generation' => $generation->getName(),
            'form' => $form->createView(),
            'posts' => $posts
        ]);
    }

    #[Route('/{brand}/{model}/{generation}/{body}/', name: 'blog_engine')]
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
        $posts = $this->postRepository->getPostsByCarBody($brand,$model,$generation,$body);

        $form = $this->formFactory->create(ChoicesEngineType::class,[],[
            'engine' => $engine
        ]);

        $form->handleRequest($request);
        if ($form->isSubmitted())
        {
            $engine = $form->getData()['engine'];
            return $this->redirect($request->getUri().$engine);
        }
        return $this->render('/blog/index.html.twig',[
            'brand' => $brand->getName(),
            'model' => $model->getName(),
            'generation' => $generation->getName(),
            'body' => $body->getName(),
            'form' => $form->createView(),
            'posts' => $posts
        ]);
    }

    #[Route('/{brand}/{model}/{generation}/{body}/{engine}/', name: 'blog_all')]
    #[ParamConverter('brand', options: ['mapping' => ['brand' => 'name']])]
    #[ParamConverter('model', options: ['mapping' => ['model' => 'name']])]
    #[ParamConverter('generation', options: ['mapping' => ['generation' => 'name']])]
    #[ParamConverter('body', options: ['mapping' => ['body' => 'name']])]
    #[ParamConverter('engine', options: ['mapping' => ['engine' => 'name']])]
    public function allComponents(Brand $brand,Model $model,Generation $generation,CarBody $body, Engine $engine): Response
    {
        $components = $this->engineRepository->checkCarExist($brand,$model,$generation,$body,$engine);
        if (empty($components))
        {
            throw new NotFoundHttpException();
        }
        $posts = $this->postRepository->getPostsByEngine($brand,$model,$generation,$body,$engine);

        return $this->render('/blog/index.html.twig',[
            'brand' => $brand->getName(),
            'model' => $model->getName(),
            'generation' => $generation->getName(),
            'body' => $body->getName(),
            'engine' => $engine->getName(),
            'posts' => $posts,
            'new' => true
            ]);
    }

    #[Route('/{brand}/{model}/{generation}/{body}/{engine}/post/{post}', name: 'blog_selected_post')]
    #[ParamConverter('brand', options: ['mapping' => ['brand' => 'name']])]
    #[ParamConverter('model', options: ['mapping' => ['model' => 'name']])]
    #[ParamConverter('generation', options: ['mapping' => ['generation' => 'name']])]
    #[ParamConverter('body', options: ['mapping' => ['body' => 'name']])]
    #[ParamConverter('engine', options: ['mapping' => ['engine' => 'name']])]
    #[ParamConverter('post')]
    public function showBlogPost(Brand $brand,Model $model,Generation $generation,CarBody $body, Engine $engine,Post $post): Response
    {
        $components = $this->engineRepository->checkCarExist($brand,$model,$generation,$body,$engine);
        if (empty($components))
        {
            throw new NotFoundHttpException();
        }
        $comments = $this->commentRepository->getCommentsPost($post);

        return $this->render('/blog/show.html.twig',[
            'brand' => $brand->getName(),
            'model' => $model->getName(),
            'generation' => $generation->getName(),
            'body' => $body->getName(),
            'engine' => $engine->getName(),
            'post' => $post,
            'comments' => $comments
        ]);
    }

    #[Route('/{brand}/{model}/{generation}/{body}/{engine}/post-new/', name: 'blog_new_post')]
    #[ParamConverter('brand', options: ['mapping' => ['brand' => 'name']])]
    #[ParamConverter('model', options: ['mapping' => ['model' => 'name']])]
    #[ParamConverter('generation', options: ['mapping' => ['generation' => 'name']])]
    #[ParamConverter('body', options: ['mapping' => ['body' => 'name']])]
    #[ParamConverter('engine', options: ['mapping' => ['engine' => 'name']])]
    public function newPost(Request $request,Brand $brand,Model $model,Generation $generation,CarBody $body, Engine $engine): RedirectResponse|Response
    {
        $components = $this->engineRepository->checkCarExist($brand,$model,$generation,$body,$engine);
        if (empty($components))
        {
            throw new NotFoundHttpException();
        }

        $post = new Post();
        $form = $this->formFactory->create(PostType::class,$post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $post = $form->getData();

            $post->setBrand($brand);
            $post->setModel($model);
            $post->setGeneration($generation);
            $post->setCarBody($body);
            $post->setEngine($engine);
            $post->setUser($this->userRepository->find($this->security->getUser()));

            $this->entityManager->persist($post);
            $this->entityManager->flush();

            $this->addFlash('success',"Your post was added");

            return $this->redirectToRoute('blog_all',[
                'brand' => $brand,
                'model' => $model,
                'generation' => $generation,
                'body' => $body,
                'engine' => $engine
            ]);
        }
        return $this->render('/blog/new.html.twig',[
            'form' => $form->createView(),
            'brand' => $brand->getName(),
            'model' => $model->getName(),
            'generation' => $generation->getName(),
            'body' => $body->getName(),
            'engine' => $engine->getName(),
        ]);
    }

    #[Route('/{brand}/{model}/{generation}/{body}/{engine}/post/{post}/comment-new', name: 'blog_new_comment',methods: 'POST')]
    #[ParamConverter('brand', options: ['mapping' => ['brand' => 'name']])]
    #[ParamConverter('model', options: ['mapping' => ['model' => 'name']])]
    #[ParamConverter('generation', options: ['mapping' => ['generation' => 'name']])]
    #[ParamConverter('body', options: ['mapping' => ['body' => 'name']])]
    #[ParamConverter('engine', options: ['mapping' => ['engine' => 'name']])]
    #[ParamConverter('post')]
    public function newComment(Request $request,Brand $brand,Model $model,Generation $generation,CarBody $body, Engine $engine, Post $post): JsonResponse
    {
        if (! $request->isXmlHttpRequest()) {

            return new JsonResponse(['error' => 'this is not ajax.'], 400);
        }

        $components = $this->engineRepository->checkCarExist($brand,$model,$generation,$body,$engine);
        if (empty($components))
        {
            throw new NotFoundHttpException();
        }

        $comment = new Comment();

        $comment->setUser($this->userRepository->find($this->getUser()));
        $comment->setPost($post);
        $comment->setContent($request->request->get('text'));

        $this->entityManager->persist($comment);
        $this->entityManager->flush();

        return new JsonResponse([
            'content' => $comment->getContent(),
            'user' => $comment->getUser()->getName(). " ".$comment->getUser()->getSurname(),
            'createdAt' => date_format(new \DateTime('now'),"F jS \\a\\t g:ia"),
            'createdBy' => $comment->getUser()->getName()." ".$comment->getUser()->getSurname(),
            'comment' => $comment->getId()

        ],200);
    }

    #[Route('/{brand}/{model}/{generation}/{body}/{engine}/post/{post}/remove-comment', name: 'blog_remove_comment',methods: 'DELETE')]
    #[ParamConverter('brand', options: ['mapping' => ['brand' => 'name']])]
    #[ParamConverter('model', options: ['mapping' => ['model' => 'name']])]
    #[ParamConverter('generation', options: ['mapping' => ['generation' => 'name']])]
    #[ParamConverter('body', options: ['mapping' => ['body' => 'name']])]
    #[ParamConverter('engine', options: ['mapping' => ['engine' => 'name']])]
    #[ParamConverter('post')]
    public function removeComment(Request $request,Brand $brand,Model $model,Generation $generation,CarBody $body, Engine $engine, Post $post): JsonResponse
    {
        if (! $request->isXmlHttpRequest()) {

            return new JsonResponse(['error' => 'this is not ajax.'], 400);
        }

        $comment = $this->commentRepository->find($request->request->get('comment'));
        if (! $this->getUser() == $comment->getUser())
        {
            return new JsonResponse(['access_denied' => 'User does not have permission'],401);
        }

        $components = $this->engineRepository->checkCarExist($brand,$model,$generation,$body,$engine);
        if (empty($components))
        {
            throw new NotFoundHttpException();
        }

        $this->entityManager->remove($comment);
        $this->entityManager->flush();

        return new JsonResponse([
            'content' => 'Post was remove'
        ],200);
    }

    #[Route('-posts-user/', name: 'blog_user_post')]
    public function userPosts(): Response
    {
        $posts = $this->postRepository->getPostsUser();

        return $this->render('/blog/userPosts.html.twig',[
            'posts' => $posts
        ]);
    }

    #[Route('-posts-user/post/{post}/remove', name: 'blog_user_post_remove')]
    #[ParamConverter('post')]
    public function userPostRemove(Post $post): RedirectResponse
    {
        if ($this->security->getUser() !== $post->getUser())
        {
            $this->addFlash('danger', "Access denied. This is not your post");

            return $this->redirect($this->generateUrl('blog_user_post'));
        }

        $this->entityManager->remove($post);
        $this->entityManager->flush();

        $this->addFlash('success',"Your post was remove");

        return $this->redirect($this->generateUrl('blog_user_post'));
    }
}
