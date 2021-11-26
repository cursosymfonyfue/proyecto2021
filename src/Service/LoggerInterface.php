<?php

declare(strict_types=1);


namespace App\Service;

interface LoggerInterface
{
    public function writeInLog(): void;

}