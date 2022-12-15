<?php

namespace aoc\advent_of_code\y2022\day_03;

use SplFileObject;

/**
 * https://adventofcode.com/2022/day/3
 *
 */
class RucksackReorganization
{

    public function __construct()
    {

        // Eingabe
        $input_file = new SplFileObject(__DIR__ . '/input.txt');

        $sum_a = 0;
        $sum_b = 0;
        $group = [];

        // Verarbeitung
        while (($items = $input_file->fgets())) {

            // Teil 1
            $items              = trim($items); //
            $half               = intdiv(strlen($items), 2);
            $compartments_left  = substr($items, 0, $half);
            $compartments_right = substr($items, $half, $half);

            foreach (str_split($compartments_left) as $item_left) {
                foreach (str_split($compartments_right) as $item_right) {
                    if ($item_left === $item_right) {
                        $sum_a += $this->getPointValue($item_left);
                        break 2;
                    }
                }
            }


            // Teil 2
            $group[] = $items;
            if (count($group) === 3) {
                foreach (str_split($group[0]) as $item) {
                    if (
                        str_contains($group[1], $item) &&
                        str_contains($group[2], $item)
                    ) {
                        $sum_b += $this->getPointValue($item);
                        break;
                    }
                }
                $group = []; // Reset
            }

        }


        // Ausgabe Teil 1
        print_r($sum_a);
        print_r(PHP_EOL);

        // Ausgabe Teil 2
        print_r($sum_b);
        print_r(PHP_EOL);

        // expections


    }


    /**
     * @param string $chr
     * @return int
     */
    private function getPointValue(string $chr): int
    {
        $chr_pos = ord($chr);
        return $chr_pos > 90
            ? $chr_pos - 96  // a-z
            : $chr_pos - 38; // A-Z
    }

}