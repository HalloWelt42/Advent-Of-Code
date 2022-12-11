<?php

namespace aoc\advent_of_code\y2022\day_1;

use SplFileObject;

/**
 * https://adventofcode.com/2022/day/1
 *
 */
class CalorieCounting
{
    public function __destruct()
    {
        // Eingabe
        $input_file = new SplFileObject(__DIR__ . '/input.txt');

        // Verarbeitung
        $calorie_sum = [];
        $calories    = 0;

        while (($meal = $input_file->fgets())) {
            $calories += (int)$meal;
            if ((int)$meal === 0) {
                $calorie_sum[] = $calories;
                $calories      = 0;
            }
        }

        $calorie_sum[] = $calories;
        rsort($calorie_sum, SORT_NUMERIC);

        // Ausgabe Teil 1
        print_r($calorie_sum[0]);
        print_r(PHP_EOL);

        // Ausgabe Teil 2
        print_r($calorie_sum[0] + $calorie_sum[1] + $calorie_sum[2]);
        print_r(PHP_EOL);
    }
}
