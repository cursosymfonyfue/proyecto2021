<?php declare(strict_types=1);

namespace App\Context\Common\Processor;

use Symfony\Component\DependencyInjection\EnvVarProcessorInterface;

final class PipedProcessor implements EnvVarProcessorInterface
{
    public function getEnv(string $prefix,
                           string $name,
                           \Closure $getEnv)
    {
        $env = $getEnv($name);

        return strpos($env, '|')?explode('|',$env):null;
    }

    public static function getProvidedTypes()
    {
        return ['piped' => 'array'];
    }
}
