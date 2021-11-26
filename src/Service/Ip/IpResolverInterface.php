<?php

declare(strict_types=1);

namespace App\Service\Ip;

interface IpResolverInterface
{
    public function resolveIp(): ?string;
}
