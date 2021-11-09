<?php

declare(strict_types=1);


namespace App\Exception;

final class LoggerFileException extends \Exception
{
    public static function fromWrittingInFile(string $fileName): self
    {
        return new self('Error trying write in file: '.$fileName);
    }
}