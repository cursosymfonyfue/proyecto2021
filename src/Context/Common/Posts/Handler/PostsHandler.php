<?php

declare(strict_types=1);

namespace App\Context\Common\Posts\Handler;

use App\Repository\PostRepository;

final class PostsHandler
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function handle(string $searchTerm): ?array
    {
        return $this->postRepository->findPostBySearchCriteria($searchTerm) ?? [];
    }
}
