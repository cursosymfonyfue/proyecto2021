<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(Request $request, PostRepository $postRepository): Response
    {
        $searchTerm = $request->query->get('search', '');
        $posts = $postRepository->findPostBySearchCriteria($searchTerm);

        return $this->render('dashboard/index.html.twig', [
            'posts' => $posts,
        ]);
    }
}
