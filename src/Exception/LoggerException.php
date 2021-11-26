<?php

declare(strict_types=1);


namespace App\Exception;

final class LoggerException extends \Exception
{
    public static function fromWrittingInFile(string $fileName): self
    {
        return new self('Error trying write in file: '.$fileName);
    }

    public static function fromPersist(string $fileName): self
    {
        return new self('Error trying persisting in database: '.$fileName);
    }
}