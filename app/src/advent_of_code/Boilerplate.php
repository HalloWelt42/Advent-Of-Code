<?php

namespace aoc\advent_of_code;


use SplFileObject;

/**
 * https://adventofcode.com/yyyy/day/d
 *
 */
class Boilerplate
{
    public function __construct()
    {
        // Eingabe
        $input_file = new SplFileObject(__DIR__ . '/input.txt');

        // Verarbeitung
        $sum_a = 0;
        $sum_b = 0;

        while (($data = $input_file->fgets())) {
            $data = trim($data);
            // your solve
        }


        // Ausgabe Teil 1
//        print_r($sum_a);
        print_r(PHP_EOL);

        // Ausgabe Teil 2
//        print_r($sum_b);
        print_r(PHP_EOL);
    }

}