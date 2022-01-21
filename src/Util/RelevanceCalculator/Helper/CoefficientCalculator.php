<?php

declare(strict_types=1);

namespace App\Util\RelevanceCalculator\Helper;

final class CoefficientCalculator
{
    public static function calculate(int $visits, int $likes, int $days): float
    {
        return round(($likes * 2 + $visits * 1.5) / ($days + 1), 2);
    }
}
