<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index(): Response
    {
        $pathfile = "../public/blog.json";
        $jsonFile = file_get_contents($pathfile);
        $jsonContent = json_decode($jsonFile, true);
        $posts = reset($jsonContent);

        return $this->render('dashboard/index.html.twig', [
            'posts' => $posts,
        ]);
    }
}
