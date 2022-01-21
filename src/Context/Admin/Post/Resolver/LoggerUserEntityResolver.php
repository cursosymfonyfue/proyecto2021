<?php

declare(strict_types=1);

namespace App\Context\Admin\Post\Resolver;

use App\Context\Admin\Post\Repository\UserFinder;
use App\Entity\User;

final class LoggerUserEntityResolver
{
    private UserFinder $userFinder;

    public function __construct(UserFinder $userFinder)
    {
        $this->userFinder = $userFinder;
    }

    public function resolve(): ?User
    {
        return $this->userFinder->findFirstUser();
    }
}
