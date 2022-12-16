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
    private string        $display;

    public function __construct(string $file)
    {
        $this->input_file = new SplFileObject($file);
        $this->sum_a      = 0;
        $this->display    = '';
    }


    /**
     * @return int test=13140 ,11780
     */
    public function PartOne(): int
    {

        $x        = 1;
        $cycles   = 0;
        $register = 0;

        while ($this->input_file->eof() === false) {

            $bash_command = $this->input_file->fgets();
            $input        = trim($bash_command);

            $cycles_required = 0;

            if ($input === 'noop') {
                $cycles_required = 1;
            }

            if (preg_match('/addx (-*\d+)/', $input, $val)) {
                $register        = (int)$val[1];
                $cycles_required = 2;

            }

            for ($cycle = 1; $cycles_required >= $cycle; $cycle++) {
                $cycles++;

                $pixel         =
                    ($cycles - 1) % 40 === $x - 1 ||
                    ($cycles - 1) % 40 === $x     ||
                    ($cycles - 1) % 40 === $x + 1;
                $this->display .= $pixel ? '#' : '.';


                if ($cycles % 40 === 0) {
                    $this->display .= PHP_EOL;
                }

                if (($cycles + 20) % 40 === 0) {
                    $this->sum_a += $x * $cycles;
                }

                if ($cycle === 2) {
                    $x += $register;
                }


            }

        }

        return $this->sum_a;
    }

    public function PartTow(): string
    {
        return $this->display;
    }
}
