<?php

declare(strict_types=1);

namespace App\Controller\Admin\Category;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CategoryShowController extends AbstractController
{
    /** @Route("/admin/category/show/{id}", name="admin_category_show", methods={"GET"}) */
    public function show(Category $category): Response
    {
        return $this->render('admin/category/show.html.twig', [
            'category' => $category,
        ]);
    }
}
