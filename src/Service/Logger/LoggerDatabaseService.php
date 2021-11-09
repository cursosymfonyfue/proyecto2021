<?php

declare(strict_types=1);

namespace App\Service\Logger;

use App\Entity\Log;
use App\Exception\LoggerDatabaseException;
use App\Repository\LogRepository;
use Exception;

final class LoggerDatabaseService implements LoggerInterface
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
     * @throws LoggerDatabaseException
     */
    public function log(string $line): void
    {

        try {
            $log = new Log($line);

            $this->logRepository->add($log);
        }
        catch(Exception $e)
        {
            throw LoggerDatabaseException::fromPersist($line);
        }
    }
}