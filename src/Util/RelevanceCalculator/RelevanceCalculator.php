<?php declare(strict_types=1);

namespace App\Util\RelevanceCalculator;

use App\Util\FibonacciCalculator\FibonacciCalculator;
use App\Util\RelevanceCalculator\Helper\CoefficientCalculator;

final class RelevanceCalculator
{
    const MAX_SEQUENCES = 100;

    public static function calculate(int $visits, int $likes, int $days): float
    {
        $coefficient = CoefficientCalculator::calculate($visits, $likes, $days);
        $i = $previous = 0;
        while (true) {
            $fibonacci = FibonacciCalculator::calculate($i++);
            if ($fibonacci > $coefficient) {
                return $previous;
            }

            if ($i >= self::MAX_SEQUENCES) {
                return $fibonacci;
            }

            $previous = $fibonacci;
        }
    }
}
