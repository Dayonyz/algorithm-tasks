<?php

namespace Tests\Unit;

use Exception;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../fibonacci.php';

class FibonacciTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function test_fibonacci_function_returns_correct_results()
    {
        $results = [9 => 34, 18 => 2584, 20 => 6765, 25 => 75025, 31 => 1346269];

        foreach ($results as $input => $output) {
            $this->assertEquals($output, fibonacci($input));
        }
    }

    /**
     * @throws Exception
     */
    public function test_fibonacci_no_buffer_function_returns_correct_results()
    {
        $results = [9 => 34, 18 => 2584, 20 => 6765, 25 => 75025, 31 => 1346269];

        foreach ($results as $input => $output) {
            $this->assertEquals($output, fibonacciNoBuffer($input));
        }
    }

    /**
     * @throws Exception
     */
    public function test_fibonacci_input_greater_or_equal_to_zero()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The input value must be greater than or equal to zero.');

        fibonacci(-1);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The input value must be greater than or equal to zero.');

        fibonacciNoBuffer(-1);
    }

    /**
     * @throws Exception
     */
    public function test_fibonacci_compare_time_and_memory_usage()
    {
        $testFibonacci = function (): array {
            $memoryUsage = 0;

            $startTime = microtime(true);

            fibonacci(30, $memoryUsage);

            $endTime = microtime(true);

            $duration = $endTime - $startTime;

            return ['duration' => $duration, 'memoryUsage' => $memoryUsage];
        };

        $testFibonacciNoBuffer = function (): array {
            $memoryUsage = 0;

            $startTime = microtime(true);

            fibonacciNoBuffer(30, $memoryUsage);

            $endTime = microtime(true);

            $duration = $endTime - $startTime;

            return ['duration' => $duration, 'memoryUsage' => $memoryUsage];
        };

        $result1 = $testFibonacci();
        $result2 = $testFibonacciNoBuffer();
        $timeSuperiority = round($result2['duration'] / $result1['duration'], 2);
        $memorySuperiority = round($result1['memoryUsage'] / $result2['memoryUsage'], 2);

        echo "\nFunction fibonacci(30): Time = {$result1['duration']}s, Memory = {$result1['memoryUsage']} bytes" . PHP_EOL;
        echo "\nFunction fibonacciNoBuffer(30): Time = {$result2['duration']}s, Memory = {$result2['memoryUsage']} bytes" . PHP_EOL;
        echo "\nFunction fibonacci(30) executed {$timeSuperiority} times faster than fibonacciNoBuffer(30)" . PHP_EOL;
        echo "\nFunction fibonacci(30) uses {$memorySuperiority} times more memory than than fibonacciNoBuffer(30)" . PHP_EOL;

        $this->assertGreaterThan(
            $result1['duration'],
            $result2['duration'],
            'fibonacci(n) must be faster than fibonacciNoBuffer(n)'
        );
        $this->assertLessThanOrEqual(
            $result1['memoryUsage'],
            $result2['memoryUsage'],
            'fibonacci(n) memory usage must be greater than fibonacciNoBuffer(n)'
        );
    }
}