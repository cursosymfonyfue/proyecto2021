<?php

declare(strict_types=1);

namespace App\Service\Logger\Provider;

use App\Entity\Log;
use App\Exception\LoggerException;
use App\Repository\LogRepository;
use Exception;

final class MonologProvider implements LoggerInterface
{
    private \Psr\Log\LoggerInterface $monolog;

    public function __construct(
        \Psr\Log\LoggerInterface $monolog
    ) {
        $this->monolog = $monolog;
    }

    /**
     * @param string $line
     * @throws LoggerException
     */
    public function log(string $line): void
    {

        $this->monolog->error($line);
    }
}
