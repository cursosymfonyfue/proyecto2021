<?php

declare(strict_types=1);

/**
 * Explicación binding arguments
 * Excepciones descriptivas
 * Acoplamiento siempre guardar en file
 */


namespace App\Service\Logger;

use App\Exception\LoggerFileException;
use Exception;
use Symfony\Component\Filesystem\Filesystem;

final class LoggerService
{
    private string $kernelLogDir;
    private string $kernelEnvironment;

    public function __construct(
        string $kernelLogDir,
        string $kernelEnvironment
    )
    {
        $this->kernelLogDir = $kernelLogDir;
        $this->kernelEnvironment = $kernelEnvironment;
    }

    /**
     * @param string $line
     * @throws LoggerFileException
     */
    public function log(string $line)
    {
        $file = $this->fileName();

        try {
            $filesystem = new Filesystem();

            $filesystem->appendToFile($file, $line. "\n");
        }
        catch(Exception $e)
        {
            throw LoggerFileException::fromWrittingInFile($file);
        }
    }

    private function fileName(): string
    {
        return $this->kernelLogDir . '/' . $this->kernelEnvironment . '.' . date('Ymd') . '.log';
    }
}