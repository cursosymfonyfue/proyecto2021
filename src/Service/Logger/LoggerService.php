<?php

declare(strict_types=1);


namespace App\Service\Logger;

use App\Service\Logger\Provider\LoggerInterface;

final class LoggerService
{

    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function log(string $line): void
    {
        $this->logger->log($line);
    }
}