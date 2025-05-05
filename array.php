<?php

function longestArithmeticSeries(array $input): array {
    static $output = [];
    static $sortedInput = [];
    $iterationSeries = [];

    if (!count($sortedInput)) {
        $sortedInput = array_unique($input);
        asort($sortedInput);
    }

    $firstValue = array_shift($sortedInput);

    if (!count($sortedInput)) {

        if (!count($output)) {
            return [];
        }

        // Sort series increments by elements count
        uksort($output, function ($a, $b) use ($output) {
            $aOutputMaxCount = 0;
            foreach ($output[$a] as $aItem) {
                if (count($aItem) > $aOutputMaxCount) {
                    $aOutputMaxCount = count($aItem);
                }
            }

            $bOutputMaxCount = 0;
            foreach ($output[$b] as $bItem) {
                if (count($bItem) > $bOutputMaxCount) {
                    $bOutputMaxCount = count($bItem);
                }
            }

            return $bOutputMaxCount <=> $aOutputMaxCount;
        });

        // Sort series by elements count
        foreach ($output as &$series) {
            uksort($series, function ($a, $b) use ($series) {
                return count($series[$b]) <=> count($series[$a]);
            });
        }

        //Get max length series
        $incrementKeys = array_keys($output);
        $maxSeriesLength = count($output[$incrementKeys[0]][0]);

        //Unset elements less than max length series
        foreach ($output as $inc => $seriesItems) {
            $filteredSeries = [];

            foreach ($seriesItems as $seriesItem) {
                if (count($seriesItem) === $maxSeriesLength) {
                    $filteredSeries[] = $seriesItem;
                }
            }
            if (count($filteredSeries)) {
                $output[$inc] = $filteredSeries;
            } else {
                unset($output[$inc]);
            }
        }

        $sortedInput = [];
        $result = $output;
        $output = [];

        return $result;
    }

    // Collect iteration series
    for ($i = 0; $i < count($sortedInput); $i++) {
        $diff = $sortedInput[$i] - $firstValue;

        if (!isset($iterationSeries[$diff])) {
            $iterationSeries[$diff] = [];
            $iterationSeries[$diff][$firstValue] = $firstValue;
            $iterationSeries[$diff][$sortedInput[$i]] = $sortedInput[$i];
        }

        if ($firstValue - max($iterationSeries[$diff]) === $diff) {
            $iterationSeries[$diff][$firstValue] = $firstValue;
        }

        if ($sortedInput[$i] - max($iterationSeries[$diff]) === $diff) {
            $iterationSeries[$diff][$sortedInput[$i]] = $sortedInput[$i];
        }
    }

    // Split iteration series into main output
    foreach ($iterationSeries as $inc => $series) {
        if (!isset($output[$inc])) {
            $output[$inc] = [];
        }

        if (count($output[$inc]) && max($output[$inc][count($output[$inc]) - 1]) === min($series)) {
            $forMerge = array_pop($output[$inc]);
            array_pop($forMerge);
            $output[$inc][] = array_merge($forMerge, $series);
        } else {
            $output[$inc][] = $series;
        }
    }

    return longestArithmeticSeries($sortedInput);
}