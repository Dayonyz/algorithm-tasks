<?php

/**
 *
 * @throws Exception
 */
function fibonacciRepeatedSeriesGMP(?int $n): GMP {
    if ($n < 0) {
        throw new Exception('The input value must be >= 0.');
    }

    static $buffer = [];

    if (is_null($n)) {
        $buffer = [];

        return gmp_init(0);
    }

    if (isset($buffer[$n])) {
        return $buffer[$n];
    }

    if ($n === 0) {
        $buffer[0] = gmp_init(0);
    } elseif ($n === 1 || $n === 2) {
        $buffer[$n] = gmp_init(1);
    } else {
        $half = (int)floor($n / 2);

        if ($n & 1) {
            $f1 = fibonacciRepeatedSeriesGMP($half + 1);
            $f2 = fibonacciRepeatedSeriesGMP($half);
            $buffer[$n] = gmp_add(gmp_mul($f1, $f1), gmp_mul($f2, $f2));
        } else {
            $fHalf = fibonacciRepeatedSeriesGMP($half);
            $fHalfMinus1 = fibonacciRepeatedSeriesGMP($half - 1);
            $buffer[$n] = gmp_mul($fHalf, gmp_add(gmp_mul(gmp_init(2), $fHalfMinus1), $fHalf));
        }
    }

    return $buffer[$n];
}

/**
 *
 * @throws Exception
 */
function fibonacciStraightGMP(?int $n): GMP {
    if ($n < 0) {
        throw new Exception('The input value must be >= 0.');
    }

    static $buffer = [];

    if (is_null($n)) {
        $buffer = [];

        return gmp_init(0);
    }

    if (isset($buffer[$n])) {
        return $buffer[$n];
    }

    if ($n === 0) {
        $buffer[$n] = gmp_init(0);
    } elseif ($n === 1 || $n === 2) {
        $buffer[$n] = gmp_init(1);
    } else {
        $buffer[$n] = gmp_add(fibonacciStraightGMP($n - 1), fibonacciStraightGMP($n - 2));
    }

    return $buffer[$n];
}