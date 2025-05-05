<?php

/**
 * @throws Exception
 */
function fibonacci(int $n) {
    if ($n < 0) {
        throw new Exception('The input value must be greater than or equal to zero.');
    }

    static $buffer = [];

    if (isset($buffer[$n])) {
        $result = $buffer[$n];
        $buffer = [];

        return $result;
    }

    if ($n === 0) {
        $buffer = [];

        return 0;
    } else if($n === 1 || $n === 2) {
        $buffer = [];

        return 1;
    } else if ($n > 2) {
        $half = (int)floor($n/2);

        if ($n & 1) {
            $buffer[$n] = pow(fibonacci($half + 1), 2) + pow(fibonacci($half), 2);

        } else {
            $buffer[$n] = fibonacci($half)*(2*fibonacci($half - 1) + fibonacci($half));
        }

        $result = $buffer[$n];
        $buffer = [];

        return $result;
    }
}

/**
 * @throws Exception
 */
function fibonacciNoBuffer(int $n) {
    if ($n < 0) {
        throw new Exception('The input value must be greater than or equal to zero.');
    }

    if ($n === 0) {

        return 0;
    } else if($n === 1 || $n === 2) {

        return 1;
    } else if ($n > 2) {
        return fibonacciNoBuffer($n - 1)  + fibonacciNoBuffer($n - 2);
    }
}
