<?php declare(strict_types=1);

namespace App\Tests\Unitary\RelevanceCalculator\Helper;

use App\Util\RelevanceCalculator\Helper\CoefficientCalculator;
use PHPUnit\Framework\TestCase;

// ./vendor/phpunit/phpunit/phpunit ./tests/Unitary/RelevanceCalculator/Helper/CoefficientCalculatorTest.php
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
            [1, 1, 1, 1.75],
            [10, 10, 1, 17.5],
            [20, 20, 1, 35],
            [20, 10, 2, 16.67],
            [30, 20, 2, 28.33],
        ];
    }
}
