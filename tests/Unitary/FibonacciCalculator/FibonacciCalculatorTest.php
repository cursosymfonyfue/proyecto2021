<?php declare(strict_types=1);

namespace App\Tests\Unitary\FibonacciCalculator;

use App\Util\FibonacciCalculator\FibonacciCalculator;
use PHPUnit\Framework\TestCase;

final class FibonacciCalculatorTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideTestData
     */
    public function fibonacciCalculator($index, $expectedResult)
    {
        $actualResult = FibonacciCalculator::calculate($index);

        $this->assertEquals($expectedResult, $actualResult);
    }

    public function provideTestData()
    {
        return [
            [0, 0],
            [1, 0],
            [2, 1],
            [3, 1],
            [4, 2],
            [5, 3],
            [6, 5],
            [7, 8],
            [8, 13],
            [9, 21],
            [10, 34],
        ];
    }
}
