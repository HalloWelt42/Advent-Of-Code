<?php

namespace aoc\advent_of_code\y2022\day_2\solve_short;

use SplFileObject;

/**
 * https://adventofcode.com/2022/day/2
 *
 */
class RockPaperScissors
{

    public function __construct()
    {

        /*
         gewonnen         = 6p
         verloren         = 0p
         unentschieden    = 3p
         Stein = 1p , Papier = 2p, Schere = 3p
        */

        // Regel 1
        $rules_a = [
            'AX' => 3 + 1, # Stein  Stein
            'AY' => 6 + 2, # Stein  Papier
            'AZ' => 0 + 3, # Stein  Schere
            'BX' => 0 + 1, # Papier Stein
            'BY' => 3 + 2, # Papier Papier
            'BZ' => 6 + 3, # Papier Schere
            'CX' => 6 + 1, # Schere Stein
            'CY' => 0 + 2, # Schere Papier
            'CZ' => 3 + 3, # Schere Schere
        ];

        // Regel 2
        $rules_b = [
            'X' => ['A' => 'Z', 'B' => 'X', 'C' => 'Y'], # verlieren
            'Y' => ['A' => 'X', 'B' => 'Y', 'C' => 'Z'], # unentschieden
            'Z' => ['A' => 'Y', 'B' => 'Z', 'C' => 'X'], # gewinnen
        ];

        $sum_a = $sum_b = 0;


        // Eingabe
        $file_input = new SplFileObject(__DIR__ . '/../input.txt');

        // Verarbeitung
        while (($move = $file_input->fgets())) {
            $vote = explode(' ', trim($move));

            [$vote_elf, $vote_you] = $vote;
            $sum_a       += $rules_a[$vote_elf . $vote_you];

            $win_or_loos = $vote[1];
            $you_set     = $rules_b[$win_or_loos][$vote_elf];
            $sum_b       += $rules_a[$vote_elf . $you_set];
        }


        // Ausgabe Teil 1 / 13675
        print_r($sum_a);
        print_r(PHP_EOL);

        // Ausgabe Teil 2 / 14184
        print_r($sum_b);
        print_r(PHP_EOL);


    }

}