<?php

namespace aoc\advent_of_code\y2022\day_10;

use aoc\advent_of_code\AoC;
use SplFileObject;

/**
 * https://adventofcode.com/2022/day/10
 *
 */
class CathodeRayTube implements AoC
{

    private SplFileObject $input_file;
    private int           $sum_a;
    private int           $sum_b;

    public function __construct(string $file)
    {
        $this->input_file = new SplFileObject($file);
        $this->sum_a      = 0;
        $this->sum_b      = 0;
    }


    /**
     * @return int test=13140 ,11780
     */
    public function PartOne(): int
    {

        $x        = 1;
        $cycles   = 1;
        $register = 0;

        while ($this->input_file->eof() === false) {

            $bash_command = $this->input_file->fgets();
            $input        = trim($bash_command);

            $cycles_use = 0;

            if ($input === 'noop') {
                $cycles_use = 1;
            }

            if (preg_match('/addx (-*\d+)/', $input, $val)) {
                $register   = (int)$val[1];
                $cycles_use = 2;
            }

            for ($cycle = 1; $cycles_use >= $cycle; $cycle++) {
                $cycles++;

                if ($cycle === 2) {
                    $x += $register;
                }

                if (in_array($cycles, [20, 60, 100, 140, 180, 220])) {
                    $this->sum_a += $x * $cycles;
                }

            }

        }

        return $this->sum_a;
    }

    public function PartTow(): int
    {
        return $this->sum_b;
    }
}