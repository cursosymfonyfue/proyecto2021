<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

final class HelloWorldController extends AbstractController
{
    /**
     * @Route("/hello-world", name="hello_world")
     */
    public function __invoke()
    {
        return $this->render('hello_world.html.twig');
    }
}
