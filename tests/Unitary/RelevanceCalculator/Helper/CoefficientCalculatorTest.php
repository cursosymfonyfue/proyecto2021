<?php declare(strict_types=1);

namespace App\Tests\Unitary\RelevanceCalculator\Helper;

use App\Util\RelevanceCalculator\Helper\CoefficientCalculator;
use PHPUnit\Framework\TestCase;

final class CoefficientCalculatorTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideTestData
     */
    public function testCalculator($visits, $likes, $days, $expectedResult)
    {
        $calculator = new CoefficientCalculator();
        $actualResult = $calculator->calculate($visits, $likes, $days);

        $this->assertEquals($expectedResult, $actualResult);
    }

    public function provideTestData()
    {
        return [
            [0, 0, 0, 0],
            [1, 1, 1, 0],
            [10, 10, 1, 9],
            [20, 20, 1, 16],
            [20, 10, 2, 8],
        ];
    }
}
