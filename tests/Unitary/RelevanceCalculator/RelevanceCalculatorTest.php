<?php declare(strict_types=1);

namespace App\Tests\Unitary\RelevanceCalculator;

use App\Util\RelevanceCalculator\RelevanceCalculator;
use PHPUnit\Framework\TestCase;

// ./vendor/phpunit/phpunit/phpunit ./tests/Unitary/RelevanceCalculator/RelevanceCalculatorTest.php
final class RelevanceCalculatorTest extends TestCase
{
    /**
     * @test
     * @dataProvider provideTestData
     */
    public function testPostRelevanceCalculator($visits, $likes, $days, $expectedResult)
    {
        $actualResult = RelevanceCalculator::calculate($visits, $likes, $days);
        $this->assertEquals($expectedResult, $actualResult);
    }

    public function provideTestData()
    {
        return [
            [0, 0, 0, 0],
            [20, 20, 1, 34],
            [10000, 1, 1, 2584],
            [50000, 1, 1, 2584],
        ];
    }
}
