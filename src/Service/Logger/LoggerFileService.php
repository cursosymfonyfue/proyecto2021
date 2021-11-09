<?php

declare(strict_types=1);

namespace App\Service\Logger;

use App\Exception\LoggerFileException;
use Exception;
use Symfony\Component\Filesystem\Filesystem;

final class LoggerFileService implements LoggerInterface
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
    public function log(string $line): void
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