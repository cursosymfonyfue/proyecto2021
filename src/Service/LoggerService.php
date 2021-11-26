<?php

declare(strict_types=1);


namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;

final class LoggerService implements LoggerInterface
{

    private string $kernelLogDir;
    private string $kernelEnvironment;

    public function __construct(string $kernelLogDir, string $kernelEnvironment)
    {
        $this->kernelLogDir = $kernelLogDir;
        $this->kernelEnvironment = $kernelEnvironment;
    }

    public function writeInLog(): void
    {
        $fileSystem = new Filesystem();


        $filePath = $this->kernelLogDir .'/' . $this->kernelEnvironment.'-' . date("Ymd").".log";

        try{
            $fileSystem->appendToFile($filePath,"Nuevo post creado v2". "\n");

        }catch(\Exception $ex)
        {
            ////
        }
    }
}