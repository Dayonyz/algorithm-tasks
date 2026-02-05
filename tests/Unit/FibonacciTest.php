<?php

namespace Tests\Unit;

use Exception;
use PHPUnit\Framework\TestCase;

class FibonacciTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testFibonacciRepeatFormulaReturnsCorrectResults()
    {
        $results = [6 => 8, 9 => 34, 18 => 2584, 20 => 6765, 25 => 75025];

        foreach ($results as $input => $output) {
            $this->assertEquals($output, fibonacciRepeatFormula($input));
        }
    }

    /**
     * @throws Exception
     */
    public function testFibonacciStraightReturnsCorrectResults()
    {
        $results = [6 => 8, 9 => 34, 18 => 2584, 20 => 6765, 25 => 75025];

        foreach ($results as $input => $output) {
            $this->assertEquals($output, fibonacciStraight($input));
        }
    }

    /**
     * @throws Exception
     */
    public function testFibonacciInputGreaterOrEqualToZero()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The input value must be greater than or equal to zero.');

        fibonacciRepeatFormula(-1);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The input value must be greater than or equal to zero.');

        fibonacciStraight(-1);
    }
}
