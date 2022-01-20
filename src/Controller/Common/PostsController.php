<?php

declare(strict_types=1);

namespace App\Controller\Common;

use App\Context\Common\Posts\Handler\PostsHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class PostsController extends AbstractController
{
    private PostsHandler $postsHandler;

    public function __construct(PostsHandler $postsHandler)
    {
        $this->postsHandler = $postsHandler;
    }

    /** @Route("/posts", name="posts") */
    public function __invoke(Request $request)
    {
        $params = ['posts' => $this->postsHandler->handle($request->get('search', ''))];
        return $this->render('common/page/_posts.html.twig', $params);
    }
}
