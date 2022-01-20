<?php

declare(strict_types=1);

namespace App\Context\Admin\Category\Form\Creator;

use App\Context\Admin\Category\Form\Type\CategoryType;
use App\Entity\Category;
use Psr\Container\ContainerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

final class AdminCategoryFormCreator
{
    private FormFactoryInterface $formFactory;

    public function __construct(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;
    }

    public function create(Category $category): FormInterface
    {
        $form = $this->formFactory->create(CategoryType::class, $category);

        $form->add('save', SubmitType::class);
        $form->add('save_and_new', SubmitType::class);


        return $form;
    }
}
