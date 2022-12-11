<?php

namespace aoc\advent_of_code\y2022\day_4;

use SplFileObject;


/**
 * https://adventofcode.com/2022/day/4
 *
 */
class CampCleanup
{

    public function __construct()
    {

        // Eingabe
        $input_file = new SplFileObject(__DIR__ . '/input.txt');

        // Verarbeitung
        $sum_a = 0;
        $sum_b = 0;

        while (($section_assignment_pair = $input_file->fgets())) {

            $section_assignment_pair = trim($section_assignment_pair);
            $pair                     = explode(',', $section_assignment_pair);
            $section_assignments_a    = explode('-', $pair[0]);
            $section_assignments_b    = explode('-', $pair[1]);
            $section_assignments_a[0] = (int)$section_assignments_a[0];
            $section_assignments_a[1] = (int)$section_assignments_a[1];
            $section_assignments_b[0] = (int)$section_assignments_b[0];
            $section_assignments_b[1] = (int)$section_assignments_b[1];

            if (
                ($section_assignments_a[0] >= $section_assignments_b[0] && $section_assignments_a[1] <= $section_assignments_b[1]) ||
                ($section_assignments_a[0] <= $section_assignments_b[0] && $section_assignments_a[1] >= $section_assignments_b[1])
            ) {
                $sum_a++;
            }

            if (
                $section_assignments_a[1] >= $section_assignments_b[0] && $section_assignments_a[0] <= $section_assignments_b[1]
            ) {
                $sum_b++;
            }

        }

        // Ausgabe Teil 1
        print_r($sum_a);
        print_r(PHP_EOL);

        // Ausgabe Teil 2
        print_r($sum_b);
        print_r(PHP_EOL);

    }


}