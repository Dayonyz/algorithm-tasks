<?php

use Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

/**
 * @throws Exception
 */
$testFibonacciRepeatedSeriesGMP = function (?int $n): array {
    gc_disable();
    gc_collect_cycles();

    $beforeMemory = xdebug_memory_usage();

    $startTime = hrtime(true);

    fibonacciRepeatedSeriesGMP($n);

    $endTime = hrtime(true);

    $afterMemory = xdebug_memory_usage();

    gc_enable();

    $duration = $endTime - $startTime;

    return ['duration' => $duration, 'memory' => $afterMemory - $beforeMemory];
};

/**
 * @throws Exception
 */
$testFibonacciStraightGMP = function (?int $n): array {
    gc_disable();
    gc_collect_cycles();

    $beforeMemory = xdebug_memory_usage();

    $startTime = hrtime(true);

    fibonacciStraightGMP($n);

    $endTime = hrtime(true);

    $afterMemory = xdebug_memory_usage();

    $duration = $endTime - $startTime;

    return ['duration' => $duration, 'memory' => $afterMemory - $beforeMemory];
};

for ($i = 1; $i <= 10; $i ++) {
    $elements = $i*1000;

    $testFibonacciRepeatedSeriesGMP(null);
    $testFibonacciStraightGMP(null);

    $resultRepeatedSeries = $testFibonacciRepeatedSeriesGMP($elements);
    $resultStraight = $testFibonacciStraightGMP($elements);

    $timeSuperiority = round($resultStraight['duration'] / $resultRepeatedSeries['duration'], 2);
    $memorySuperiority = round( $resultStraight['memory'] / $resultRepeatedSeries['memory'], 2);

    echo "Fibonacci(N), N = {$elements}: \r\n";
    echo sprintf(
        "Function fibonacciStraight($elements): Time = %s ns, Memory = %s bytes%s",
        $resultStraight['duration'],
        $resultStraight['memory'],
        PHP_EOL
    );

    echo sprintf(
        "Function fibonacciRepeatedSeriesGMP($elements): Time = %s ns, Memory = %s bytes%s",
        $resultRepeatedSeries['duration'],
        $resultRepeatedSeries['memory'],
        PHP_EOL
    );

    echo sprintf(
        "Function fibonacciRepeatedSeriesGMP($elements) executed %s times faster than fibonacciStraightGMP($elements)%s",
        $timeSuperiority,
        PHP_EOL
    );

    echo sprintf(
        "Function fibonacciStraightGMP($elements) consumed %s× more memory than fibonacciRepeatedSeriesGMP($elements)%s",
        $memorySuperiority,
        PHP_EOL
    );
    echo "\r\n";
}


