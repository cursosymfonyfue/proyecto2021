<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DummyController extends AbstractController
{
    public function __construct(ParameterBagInterface $parameterBag)
    {
        // die($parameterBag->get('last_env_file'));
    }

    /**
     * @Route("/dummy", name="dummy")
     */
    public function index(Request $request, PostRepository $postRepository): Response
    {
        return new Response('hi!');
    }
}
