<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    /**
     * @Route("/search", name="search")
     */
    public function __invoke(Request $request, PostRepository $postRepository): Response
    {
        $searchTerm = $request->query->get('q', '');
        $posts = $postRepository->findPostBySearchCriteria($searchTerm);

        return $this->render('search/index.html.twig', [
            'posts' => $posts,
        ]);
    }
}
