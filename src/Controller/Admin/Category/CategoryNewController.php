<?php

declare(strict_types=1);

namespace App\Controller\Admin\Category;

use App\Context\Admin\Category\AdminCategoryHandler;
use App\Context\Admin\Category\Form\Creator\AdminCategoryFormCreator;
use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CategoryNewController extends AbstractController
{
    private AdminCategoryFormCreator $adminCategoryFormCreator;
    private AdminCategoryHandler $adminCategoryHandler;

    public function __construct(
        AdminCategoryFormCreator $adminCategoryFormCreator,
        AdminCategoryHandler $adminCategoryHandler
    ) {
        $this->adminCategoryFormCreator = $adminCategoryFormCreator;
        $this->adminCategoryHandler = $adminCategoryHandler;
    }

    /** @Route("/admin/category/new", name="admin_category_new", methods={"GET","POST"}) */
    public function __invoke(Request $request): Response
    {
        $category = new Category();
        $form = $this->adminCategoryFormCreator->create($category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->adminCategoryHandler->handle($category);

            $button = self::resolveSaveAndNewButton($form);
            $route = $button->isClicked()
                ? 'admin_category_new'
                : 'admin_category_index';

            return $this->redirectToRoute($route, [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/category/new.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

    private static function resolveSaveAndNewButton($form): SubmitButton
    {
        $button = $form->get('save_and_new');
        if ($button instanceof SubmitButton) {
            return $button;
        }

        throw new \Exception('save_and_new button must be instance of SubmitButton');
    }
}
