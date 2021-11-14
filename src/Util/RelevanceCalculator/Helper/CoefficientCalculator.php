<?php declare(strict_types=1);

namespace App\Util\RelevanceCalculator\Helper;

final class CoefficientCalculator
{
    public static function calculate(int $visits, int $likes, int $days) : float
    {
        return $likes ^ 2 * sqrt($visits) / ($days + 1);
    }
}
