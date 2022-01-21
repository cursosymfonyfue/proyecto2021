<?php

namespace App\Event;

use Symfony\Contracts\EventDispatcher\Event;

class AddedLikeEvent extends Event
{
    public const NAME = 'like.added';

    private int $postId;

    public function __construct(int $postId)
    {
        $this->postId = $postId;
    }

    public function getPostId(): int
    {
        return $this->postId;
    }
}
