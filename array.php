<?php

function longestArithmeticSeries(array $input): array
{
    $nums = array_values(array_unique($input));
    sort($nums);

    $series = [];

    $n = count($nums);
    for ($i = 0; $i < $n; $i++) {
        for ($j = $i + 1; $j < $n; $j++) {
            $d = $nums[$j] - $nums[$i];
            $current = [$nums[$i], $nums[$j]];
            $next = $nums[$j] + $d;

            while (in_array($next, $nums, true)) {
                $current[] = $next;
                $next += $d;
            }

            if (count($current) > 2) {
                $series[$d][] = $current;
            }
        }
    }

    if (! $series) {
        return [];
    }

    $maxLen = max(
        array_map(
            fn ($items) => max(array_map('count', $items)),
            $series
        )
    );

    foreach ($series as $d => $items) {
        $series[$d] = array_values(
            array_filter($items, fn ($s) => count($s) === $maxLen)
        );

        if (! $series[$d]) {
            unset($series[$d]);
        }
    }

    return $series;
}
