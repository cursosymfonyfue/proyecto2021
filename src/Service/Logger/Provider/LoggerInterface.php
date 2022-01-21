<?php

declare(strict_types=1);

namespace App\Service\Logger\Provider;

interface LoggerInterface
{
    public function log(string $line): void;
}
