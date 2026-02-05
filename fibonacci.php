<?php

/**
 * @throws Exception
 */
function fibonacciRepeatedSeries(int $n): int {
    if ($n < 0) {
        throw new Exception('The input value must be greater than or equal to zero.');
    }

    static $buffer = [];

    if (isset($buffer[$n])) {
        return $buffer[$n];
    }

    if ($n === 0) {
        $buffer[0] = 0;
    } elseif ($n === 1 || $n === 2) {
        $buffer[$n] = 1;
    } else {
        $half = (int)floor($n / 2);

        if ($n & 1) {
            $buffer[$n] = pow(fibonacciRepeatedSeries($half + 1), 2) +
                pow(fibonacciRepeatedSeries($half), 2);
        } else {
            $buffer[$n] = fibonacciRepeatedSeries($half) *
                (2 * fibonacciRepeatedSeries($half - 1) +
                    fibonacciRepeatedSeries($half));
        }
    }

    return $buffer[$n];
}

/**
 * @throws Exception
 */
function fibonacciStraight(int $n): int
{
    if ($n < 0) {
        throw new Exception('The input value must be greater than or equal to zero.');
    }

    static $buffer = [];

    if ($n === 0) {
        $buffer[$n] = 0;
    } else if($n === 1 || $n === 2) {
        $buffer[$n] = 1;
    } else {
        $buffer[$n] = fibonacciStraight($n - 1) + fibonacciStraight($n - 2);
    }

    return $buffer[$n];
}