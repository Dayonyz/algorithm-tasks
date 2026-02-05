<?php

use Dotenv\Dotenv;

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$testFibonacciRepeatFormula = function (): array {
    gc_disable();
    gc_collect_cycles();

    $beforeMemory = xdebug_memory_usage();

    $startTime = hrtime(true);

    fibonacciRepeatFormula(30);

    $endTime = hrtime(true);

    $afterMemory = xdebug_memory_usage();

    gc_enable();

    $duration = $endTime - $startTime;

    return ['duration' => $duration, 'memory' => $afterMemory - $beforeMemory];
};

$testFibonacciStraight = function (): array {
    gc_disable();
    gc_collect_cycles();

    $beforeMemory = xdebug_memory_usage();

    $startTime = hrtime(true);

    fibonacciStraight(30);

    $endTime = hrtime(true);

    $afterMemory = xdebug_memory_usage();

    $duration = $endTime - $startTime;

    return ['duration' => $duration, 'memory' => $afterMemory - $beforeMemory];
};

$resultRepeatFormula = $testFibonacciRepeatFormula();
$resultStraight = $testFibonacciStraight();
$timeSuperiority = round($resultStraight['duration'] / $resultRepeatFormula['duration'], 2);
$memorySuperiority = round( $resultStraight['memory'] / $resultRepeatFormula['memory'], 2);

echo "\nFunction fibonacciRepeatFormula(30): Time = {$resultRepeatFormula['duration']}ns, Memory = {$resultRepeatFormula['memory']} bytes" . PHP_EOL;
echo "\nFunction fibonacciStraight(30): Time = {$resultStraight['duration']}ns, Memory = {$resultStraight['memory']} bytes" . PHP_EOL;
echo "\nFunction fibonacciRepeatFormula(30) executed {$timeSuperiority} times faster than fibonacciStraight(30)" . PHP_EOL;
echo "\nFunction fibonacciStraight(30) consumed {$memorySuperiority}× more memory than fibonacciRepeatFormula(30)" . PHP_EOL;
