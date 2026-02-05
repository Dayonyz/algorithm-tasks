<?php

/**
 * @throws Exception
 */
function fibonacci(int $n, int &$memoryUsage = 0) {
    $startMemory = memory_get_usage();

    if ($n < 0) {
        throw new Exception('The input value must be greater than or equal to zero.');
    }

    static $buffer = [];

    if (isset($buffer[$n])) {
        $result = $buffer[$n];
        $memoryUsage += memory_get_usage() - $startMemory;

        $buffer = [];

        return $result;
    }

    if ($n === 0) {
        $memoryUsage += memory_get_usage() - $startMemory;

        $buffer = [];

        return 0;
    } else if($n === 1 || $n === 2) {
        $buffer = [];

        return 1;
    } else if ($n > 2) {
        $half = (int)floor($n/2);

        if ($n & 1) {
            $buffer[$n] = pow(fibonacci($half + 1, $memoryUsage), 2) + pow(fibonacci($half, $memoryUsage), 2);

        } else {
            $buffer[$n] = fibonacci($half, $memoryUsage)*(2*fibonacci($half - 1, $memoryUsage) + fibonacci($half, $memoryUsage));
        }
        $result = $buffer[$n];

        $memoryUsage += memory_get_usage() - $startMemory;

        $buffer = [];

        return $result;
    }
}

/**
 * @throws Exception
 */
function fibonacciNoBuffer(int $n, int &$memoryUsage = 0) {
    $startMemory = memory_get_usage();

    if ($n < 0) {
        throw new Exception('The input value must be greater than or equal to zero.');
    }

    if ($n === 0) {
        $memoryUsage += memory_get_usage() - $startMemory;

        return 0;
    } else if($n === 1 || $n === 2) {
        $memoryUsage += memory_get_usage() - $startMemory;

        return 1;
    } else if ($n > 2) {
        $result = fibonacciNoBuffer($n - 1, $memoryUsage) + fibonacciNoBuffer($n - 2, $memoryUsage);

        $memoryUsage += memory_get_usage() - $startMemory;

        return $result;
    }
}
