<?php

declare(strict_types=1);


namespace App\Service;

use App\Entity\Log;
use App\Repository\LogRepository;
use Symfony\Component\Filesystem\Filesystem;

final class LoggerDatabaseService implements LoggerInterface
{


    private LogRepository $repository;

    public function __construct(LogRepository $repository)
    {
        $this->repository = $repository;
    }

    public function writeInLog(): void
    {
        $content = "Nuevo post creado v3";

        $log = new Log();
        $log->setContent($content);

        $this->repository->add($log);
    }
}