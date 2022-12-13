<?php

namespace aoc\advent_of_code\y2022\day_9;

use aoc\advent_of_code\AoC;
use SplFileObject;

class RopeBridge implements AoC
{

    private SplFileObject $input_file;
    private int           $sum_a;
    private int           $sum_b;
    private Tail          $tail;
    private Head          $head;

    /**
     * @var Position[]
     */
    private array $directions;

    public function __construct(string $file)
    {
        $this->input_file = new SplFileObject($file);
        $this->sum_a      = 0;
        $this->sum_b      = 0;
        $this->directions = [
            'D' => Position::down,
            'U' => Position::up,
            'L' => Position::left,
            'R' => Position::right,
        ];
        $this->head       = new Head();
        $this->tail       = new Tail();
    }

    public function PartOne(): int
    {

        while ($this->input_file->eof() === false) {
            $bash_command = $this->input_file->fgets();
            $input        = trim($bash_command);
            $parts        = explode(' ', $input);
            [$direction, $repetitions] = $parts;

            // move the head
            for ($i = 0; (int)$repetitions > $i; $i++) {
                $this->head->move($this->directions[$direction]);
                $this->tail->move2Head($this->head);
            }
        }

        $this->sum_a = $this->tail->getAllVisits();
        return $this->sum_a;
    }

    public function PartTow(): int
    {
        return $this->sum_b;
    }
}