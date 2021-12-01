<?php declare(strict_types=1);

namespace App\Controller\Common;

use App\Context\Common\Categories\Handler\CategoriesHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

final class CategoriesController extends AbstractController
{
    private CategoriesHandler $categoriesHandler;

    public function __construct(CategoriesHandler $categoriesHandler)
    {
        $this->categoriesHandler = $categoriesHandler;
    }

    /** @Route("/categories", name="categories") */
    public function __invoke()
    {
        $params = ['categories' => $this->categoriesHandler->handle()];
        return $this->render('common/page/_categories.html.twig', $params);
    }
}
