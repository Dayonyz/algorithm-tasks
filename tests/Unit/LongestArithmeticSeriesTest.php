<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../../array.php';

class LongestArithmeticSeriesTest extends TestCase
{
    public function test_empty_input_returns_empty_array()
    {
        $results = [];

        $this->assertEquals($results, longestArithmeticSeries([]));
    }

    public function test_one_series_result()
    {
        $input = [1, 4, 7, 5, 3, 9];

        $results = [
            2 =>
                [
                    [1, 3, 5, 7, 9]
                ]
        ];

        $this->assertEquals($results, longestArithmeticSeries($input));
    }

    public function test_doubled_values_splits_to_one()
    {
        $input = [1, 4, 7, 7, 5, 3, 9, 5];

        $results = [
            2 =>
                [
                    [1, 3, 5, 7, 9]
                ]
        ];

        $this->assertEquals($results, longestArithmeticSeries($input));
    }

    public function test_two_series_results_same_length_with_different_inc_and_cross_elements()
    {
        $input = [1, 4, 7, 5, 3, 9, 10, 13];

        $results = [
            2 =>
                [
                    [1, 3, 5, 7, 9]
                ],
            3 =>
                [
                    [1, 4, 7, 10, 13]
                ]
        ];

        $this->assertEquals($results, longestArithmeticSeries($input));
    }

    public function test_three_results_same_length_but_two_results_with_same_inc()
    {
        $input = [1, 4, 7, 5, 3, 9, 10, 13, 18, 23, 28, 33, 40, 45, 50, 55, 60];
        $results = [
            2 =>
                [
                    [1, 3, 5, 7, 9]
                ],
            3 =>
                [
                    [1, 4, 7, 10, 13]
                ],
            5 =>
                [
                    [13, 18, 23, 28, 33],
                    [40, 45, 50, 55, 60]
                ]
        ];

        $this->assertEquals($results, longestArithmeticSeries($input));
    }
}