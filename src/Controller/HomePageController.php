<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

final class HomePageController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
     */
    public function __invoke()
    {
        return $this->render('home_page.html.twig');
    }
}
