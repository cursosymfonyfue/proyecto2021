<?php

namespace App\Events;

use Symfony\Contracts\EventDispatcher\Event;

class NewLikeAddedEvent extends Event
{
    public const NAME = 'like.added';

    protected int $postId;

    public function __construct($postId)
    {
        $this->postId = $postId;
    }

    public function postId(): int
    {
        return $this->postId;
    }
}
