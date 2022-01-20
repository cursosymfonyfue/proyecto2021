<?php

declare(strict_types=1);

namespace App\Controller\Common;

use App\Events\NewLikeAddedEvent;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class LikeAddController extends AbstractController
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /** @Route("/add-like", name="add_like") */
    public function __invoke(Request $request, EventDispatcherInterface $eventDispatcher)
    {
        $postId = (int)$request->get('id', 0);
        $this->postRepository->incrementNumberOfLikesByOne($postId);

        $eventDispatcher->dispatch(new NewLikeAddedEvent($postId), NewLikeAddedEvent::NAME);

        return new Response('ok');
    }
}
