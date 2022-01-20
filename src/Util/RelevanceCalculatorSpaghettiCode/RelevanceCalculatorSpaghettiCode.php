<?php

declare(strict_types=1);

namespace App\Util\RelevanceCalculatorSpaghettiCode;

final class RelevanceCalculatorSpaghettiCode
{
    private const MAX_SEQUENCES = 100;

    public static function calculate(int $visits, int $likes, int $days): float
    {
        $coefficient = $likes ^ 2 * sqrt($visits) / ($days + 1);

        $i = $previous = 0;
        while (true) {
            $index = $i++;

            $fibonacci = (int)round(pow((sqrt(5) + 1) / 2, --$index) / sqrt(5));

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
