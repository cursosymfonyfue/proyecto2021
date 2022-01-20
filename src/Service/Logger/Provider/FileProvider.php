<?php

declare(strict_types=1);

namespace App\Service\Logger\Provider;

use App\Exception\LoggerException;
use Exception;
use Symfony\Component\Filesystem\Filesystem;

final class FileProvider implements LoggerInterface
{
    private string $kernelLogDir;
    private string $kernelEnvironment;

    public function __construct(
        string $kernelLogDir,
        string $kernelEnvironment
    ) {
        $this->kernelLogDir = $kernelLogDir;
        $this->kernelEnvironment = $kernelEnvironment;
    }

    /**
     * @param string $line
     * @throws LoggerException
     */
    public function log(string $line): void
    {
        $file = $this->fileName();

        try {
            $filesystem = new Filesystem();

            $filesystem->appendToFile($file, $line . "\n");
        } catch (Exception $e) {
            throw LoggerException::fromWrittingInFile($file);
        }
    }

    private function fileName(): string
    {
        return $this->kernelLogDir . '/' . $this->kernelEnvironment . '.' . date('Ymd') . '.log';
    }
}
