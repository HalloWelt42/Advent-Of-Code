<?php

namespace aoc\advent_of_code;


use SplFileObject;

/**
 * https://adventofcode.com/yyyy/day/d
 *
 */
class Boilerplate implements AoC
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

    public function PartOne(): int
    {

        while ($this->input_file->eof() === false) {
            $bash_command = $this->input_file->fgets();
            $input        = trim($bash_command);
        }

        return $this->sum_a;
    }

    public function PartTow(): int
    {
        return $this->sum_b;
    }
}