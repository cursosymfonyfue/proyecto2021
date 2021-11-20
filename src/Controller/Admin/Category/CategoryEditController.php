<?php

namespace App\Controller\Admin\Category;

use App\Entity\Category;
use App\Context\Admin\Category\Form\Type\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryEditController extends AbstractController
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /** @Route("/admin/category/edit/{id}", name="admin_category_edit", methods={"GET","POST"}) */
    public function edit(Request $request, Category $category): Response
    {
        // *** NOTA: *** Aquí Symfony hace magia vía ParamConverter.
        // Internamente hace un findById para el valor del {id} pasado en la ruta sobre la tabla Category
        // y devuelve la entidad.

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        $form->add('save', SubmitType::class);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->categoryRepository->save($category);
            return $this->redirectToRoute('admin_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }
}
