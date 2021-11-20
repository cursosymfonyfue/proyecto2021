<?php declare(strict_types=1);

namespace App\Tests\Unitary\Stack;

use PHPUnit\Framework\TestCase;

// ./vendor/phpunit/phpunit/phpunit tests/Unitary/Stack/StackTest
// ./vendor/phpunit/phpunit/phpunit --filter=testPushAndPop
final class StackTest extends TestCase
{
    public function testPushAndPop(): void
    {
        $stack = [];
        $this->assertEquals(0, count($stack));

        array_push($stack, 'foo');
        $this->assertEquals('foo', $stack[count($stack) - 1]);
        $this->assertEquals(1, count($stack));

        $this->assertEquals('foo', array_pop($stack));
        $this->assertEquals(0, count($stack));
    }
}
