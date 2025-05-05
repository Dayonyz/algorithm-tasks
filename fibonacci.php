<?php

/**
 * @throws Exception
 */
function fibonacci(int $n, int &$memoryUsage = 0) {
    if ($n < 0) {
        throw new Exception('The input value must be greater than or equal to zero.');
    }

    static $buffer = [];
    static $memoryUsageStart = 0;

    if ($memoryUsageStart === 0) {
        gc_collect_cycles();
        $memoryUsageStart = memory_get_usage();
    }

    if (isset($buffer[$n])) {
        $memoryUsage = memory_get_usage() - $memoryUsageStart;

        return $buffer[$n];
    }

    if ($n === 0) {
        $buffer[$n] = 0;
        $memoryUsage = memory_get_usage() - $memoryUsageStart;

        return 0;
    } else if($n === 1 || $n === 2) {
        $buffer[$n] = 1;
        $memoryUsage = memory_get_usage() - $memoryUsageStart;

        return 1;
    } else if ($n > 2) {
        $half = (int)floor($n/2);

        if ($n & 1) {
            $buffer[$n] = pow(fibonacci($half + 1), 2) + pow(fibonacci($half), 2);

        } else {
            $buffer[$n] = fibonacci($half)*(2*fibonacci($half - 1) + fibonacci($half));
        }

        $memoryUsage = memory_get_usage() - $memoryUsageStart;

        return $buffer[$n];
    }
}

/**
 * @throws Exception
 */
function fibonacciNoBuffer(int $n, int &$memoryUsage = 0) {
    if ($n < 0) {
        throw new Exception('The input value must be greater than or equal to zero.');
    }

    static $memoryUsageStart = 0;

    if ($memoryUsageStart === 0) {
        gc_collect_cycles();
        $memoryUsageStart = memory_get_usage();
    }

    if ($n === 0) {
        $memoryUsage = memory_get_usage() - $memoryUsageStart;

        return 0;
    } else if($n === 1 || $n === 2) {
        $memoryUsage = memory_get_usage() - $memoryUsageStart;

        return 1;
    } else if ($n > 2) {
        $memoryUsage = memory_get_usage() - $memoryUsageStart;

        return fibonacciNoBuffer($n - 1)  + fibonacciNoBuffer($n - 2);
    }
}
