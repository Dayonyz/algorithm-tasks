<?php

use Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

/**
 * @throws Exception
 */
$testFibonacciRepeatedSeriesGMP = function (): array {
    gc_disable();
    gc_collect_cycles();

    $beforeMemory = xdebug_memory_usage();

    $startTime = hrtime(true);

    fibonacciRepeatedSeriesGMP(10000);

    $endTime = hrtime(true);

    $afterMemory = xdebug_memory_usage();

    gc_enable();

    $duration = $endTime - $startTime;

    return ['duration' => $duration, 'memory' => $afterMemory - $beforeMemory];
};

/**
 * @throws Exception
 */
$testFibonacciStraightGMP = function (): array {
    gc_disable();
    gc_collect_cycles();

    $beforeMemory = xdebug_memory_usage();

    $startTime = hrtime(true);

    fibonacciStraightGMP(10000);

    $endTime = hrtime(true);

    $afterMemory = xdebug_memory_usage();

    $duration = $endTime - $startTime;

    return ['duration' => $duration, 'memory' => $afterMemory - $beforeMemory];
};

$resultRepeatedSeries = $testFibonacciRepeatedSeriesGMP();
$resultStraight = $testFibonacciStraightGMP();

$timeSuperiority = round($resultStraight['duration'] / $resultRepeatedSeries['duration'], 2);
$memorySuperiority = round( $resultStraight['memory'] / $resultRepeatedSeries['memory'], 2);

echo "\r\n";
echo sprintf(
    "Function fibonacciStraight(10000): Time = %s ns, Memory = %s bytes%s",
    $resultStraight['duration'],
    $resultStraight['memory'],
    PHP_EOL
);

echo sprintf(
    "Function fibonacciRepeatedSeriesGMP(10000): Time = %s ns, Memory = %s bytes%s",
    $resultRepeatedSeries['duration'],
    $resultRepeatedSeries['memory'],
    PHP_EOL
);

echo sprintf(
    "Function fibonacciRepeatedSeriesGMP(10000) executed %s times faster than fibonacciStraightGMP(10000)%s",
    $timeSuperiority,
    PHP_EOL
);

echo sprintf(
    "Function fibonacciStraightGMP(10000) consumed %s× more memory than fibonacciRepeatedSeriesGMP(10000)%s",
    $memorySuperiority,
    PHP_EOL
);
echo "\r\n";

