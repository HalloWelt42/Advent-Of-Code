<?php

namespace aoc\advent_of_code\y2015\day_01;

use SplFileObject;

/**
 * https://adventofcode.com/yyyy/day/d
 *
 */
class NotQuiteLisp
{
    public function __construct()
    {
        // Eingabe
        $input = file_get_contents(__DIR__ . '/input.txt');

        // Verarbeitung
        $stop = true;
        while ($stop) {
            $a     = strlen($input);
            $input = str_replace(['()', ')('], '', $input);
            $b     = strlen($input);
            if ($a === $b) {
                $stop = false;
            }
        }

        // Ausgabe Teil 1
        print_r($input[0] === '(' ? $b : -($b));
        print_r(PHP_EOL);

        $level = 0;
        $input = trim(file_get_contents(__DIR__ . '/input.txt'));
        foreach (str_split($input) as $i => $char) {
            $level += $char === '(' ? 1 : -1;
            if($level === -1){
                break;
            }
        }

        // Ausgabe Teil 2
        print_r($i+1);
        print_r(PHP_EOL);
    }

}