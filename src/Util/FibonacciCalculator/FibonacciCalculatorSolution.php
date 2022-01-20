<?php

declare(strict_types=1);

namespace App\Util\FibonacciCalculator;

final class FibonacciCalculatorSolution
{
    public static function calculate($index): int
    {
        return (int)round(pow((sqrt(5) + 1) / 2, --$index) / sqrt(5));
    }
}
