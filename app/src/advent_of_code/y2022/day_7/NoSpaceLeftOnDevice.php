<?php

namespace aoc\advent_of_code\y2022\day_7;

use aoc\advent_of_code\AoC;
use SplFileObject;

/**
 * https://adventofcode.com/2022/day/7
 *
 */
class NoSpaceLeftOnDevice implements AoC
{

    private SplFileObject $input_file;
    private array         $file_list;
    private int           $sum_a;
    private int           $sum_b;

    public function __construct(string $file)
    {
        $this->input_file = new SplFileObject($file);
        $this->sum_a      = 0;
        $this->sum_b      = 0;
    }

    private function decoder()
    {
        $key    = '/';
        $memory = [];
        while ($this->input_file->eof() === false) {
            $bash_command = $this->input_file->fgets();
            $input        = trim($bash_command);

            // cd ..
            if ($input === '$ cd ..') {
                $div                   = array_pop($memory);
                $mem_key               = $key;
                $key                   = substr($key, 0, -$div);
                $this->file_list[$key] += $this->file_list[$mem_key];
            }

            // cd [name]
            if (preg_match('/\$ cd ([a-z]+)/', $input, $matches)) {
                $memory[]        = strlen($matches[1]);
                $key             .= $matches[1];
                $this->file_list += [$key => 0];
            }

            // size
            if (preg_match('/(\d+) [a-z.]+/', $input, $matches)) {
                $this->file_list[$key] += (int)$matches[1];
            }

        }

        foreach ($memory as $element) {
            $div                   = array_pop($memory);
            $mem_key               = $key;
            $key                   = substr($key, 0, -$div);
            $this->file_list[$key] += $this->file_list[$mem_key];
        }
    }

    private function getByte(): int
    {
        $byte = 0;
        foreach ($this->file_list as $files_byte) {
            if ($files_byte <= 100_000) {
                $byte += $files_byte;
            }
        }
        return $byte;
    }

    public function PartOne(): int
    {
        $this->file_list = [];
        $this->file_list += ['/' => 0];

        $this->decoder();
        $this->sum_a = $this->getByte();
        return $this->sum_a;
    }

    public function PartTow(): int
    {
        $disc_space_total    = 70_000_000;
        $disc_space_minimum  = 30_000_000;
        $disc_space_free     = $disc_space_total - $this->file_list['/'];
        $disc_space_required = $disc_space_minimum - $disc_space_free;
        $disc_space_free_tmp = $disc_space_free;

        foreach ($this->file_list as $file_size) {
            if ($disc_space_required <= $file_size && $file_size < $disc_space_free_tmp) {
                $disc_space_free_tmp = $file_size;
            }
        }

        $this->sum_b = $disc_space_free_tmp;
        return $this->sum_b;
    }
}