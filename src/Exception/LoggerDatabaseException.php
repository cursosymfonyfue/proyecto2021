<?php

declare(strict_types=1);


namespace App\Exception;

final class LoggerDatabaseException extends \Exception
{
    public static function fromPersist(string $fileName): self
    {
        return new self('Error trying persisting in database: '.$fileName);
    }
}