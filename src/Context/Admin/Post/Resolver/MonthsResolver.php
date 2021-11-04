<?php declare(strict_types=1);

namespace App\Context\Admin\Post\Resolver;

final class MonthsResolver
{
    public static function resolve(): array{
        $meses = [];
        for ($i=1;$i<=12;$i++) {
            $nombreDeMes = \DateTime::createFromFormat('!m', (string)$i)->format('F');
            $meses[$nombreDeMes] = $i;
        }
        return $meses;
    }
}
