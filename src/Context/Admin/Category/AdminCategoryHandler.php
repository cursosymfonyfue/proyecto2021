<?php declare(strict_types=1);

namespace App\Context\Admin\Category;

use App\Entity\Category;
use App\Repository\CategoryRepository;

final class AdminCategoryHandler
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function handle(Category $category) : void
    {
        $this->categoryRepository->save($category);
        // @todo enviar e-mail
        // @todo loguear lo que sea
    }
}
