<?php

declare(strict_types=1);

namespace App\Service\Logger\Provider;

use App\Entity\Log;
use App\Exception\LoggerException;
use App\Repository\LogRepository;
use Exception;

final class DatabaseProvider implements LoggerInterface
{
    private LogRepository $logRepository;

    public function __construct(
        LogRepository $logRepository
    )
    {
        $this->logRepository = $logRepository;
    }

    /**
     * @param string $line
     * @throws LoggerException
     */
    public function log(string $line): void
    {

        try {
            $log = new Log($line);

            $this->logRepository->add($log);
        }
        catch(Exception $e)
        {
            throw LoggerException::fromPersist($line);
        }
    }
}