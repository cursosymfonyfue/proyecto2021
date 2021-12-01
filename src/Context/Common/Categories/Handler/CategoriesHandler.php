<?php declare(strict_types=1);

namespace App\Context\Common\Categories\Handler;

use App\Repository\CategoryRepository;

final class CategoriesHandler
{
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function handle(): array
    {
        return $this->categoryRepository->findAll() ?? [];
    }
}
