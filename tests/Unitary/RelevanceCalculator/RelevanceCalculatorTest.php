<?php declare(strict_types=1);

namespace App\Tests\Unitary\RelevanceCalculator;

use App\Util\RelevanceCalculator\RelevanceCalculator;
use PHPUnit\Framework\TestCase;

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
            [20, 20, 1, 13],
        ];
    }
}
