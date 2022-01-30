<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('IS_AUTHENTICATED_REMEMBERED')]
class SearchBarController extends AbstractController
{
    private $postRepository;

    public function __construct(
        PostRepository $postRepository
    ){
        $this->postRepository = $postRepository;
    }

    #[Route('/search/bar/', name: 'search_bar')]
    public function index(Request $request): Response
    {
        $text = $request->query->get("search-text");

        if ($text === '') $this->redirect($this->generateUrl('app_home'));

        $offset = max(0, $request->query->getInt('offset', 0));
        $posts = $this->postRepository->searchPosts($text,$offset);

        return $this->render('search_bar/index.html.twig', [
            'posts' => $posts,
            'previous' => $offset - PostRepository::PAGINATOR_PER_PAGE,
            'next' => min(count($posts), $offset + PostRepository::PAGINATOR_PER_PAGE)
        ]);
    }
}
