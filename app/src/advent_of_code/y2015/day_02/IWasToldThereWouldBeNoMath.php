<?php

namespace aoc\advent_of_code\y2015\day_02;

use SplFileObject;

class IWasToldThereWouldBeNoMath
{
    public function __construct()
    {
        // Eingabe
        $input_file = new SplFileObject(__DIR__ . '/input.txt');

        // Verarbeitung
        $sum_a = 0;
        $sum_b = 0;

        while (($dimensions = $input_file->fgets())) {
            $dimensions = trim($dimensions);
            $sides      = explode('x', $dimensions);
            [$a, $b, $c] = $sides;
            $areas = [
                $a * $b,
                $b * $c,
                $a * $c,
            ];

            sort($sides);

            $sum_a += (array_sum($areas) * 2) + (int)$sides[0];
            $sum_b += $a * $b * $c + (((int)$sides[0] + (int)$sides[1]) * 2);
        }


        // Ausgabe Teil 1
        print_r($sum_a);
        print_r(PHP_EOL);

        // Ausgabe Teil 2
        print_r($sum_b);
        print_r(PHP_EOL);
    }

}