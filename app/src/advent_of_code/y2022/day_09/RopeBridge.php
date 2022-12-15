<?php

namespace aoc\advent_of_code\y2022\day_09;

use aoc\advent_of_code\AoC;
use SplFileObject;

/**
 * https://adventofcode.com/2022/day/9
 *
 */
class RopeBridge implements AoC
{

    private SplFileObject $input_file;
    private int           $sum_b;

    /**
     * @var Direction[]
     */
    private array $input_direction_mapper;

    public function __construct(string $file)
    {
        $this->sum_b                  = 0;
        $this->input_file             = new SplFileObject($file);
        $this->input_direction_mapper = [
            'D' => Direction::⬇,
            'U' => Direction::⬆,
            'L' => Direction::←,
            'R' => Direction::➡,
        ];
    }


    /**
     * @param array $segment
     * @param Direction $direction ➡ ⬅ ⬇ ⬆ ↖ ↙ ↘ ↗
     * @return void
     */
    private function move(array &$segment, Direction $direction): void
    {
        switch ($direction) {
            case Direction::←;
                --$segment['x'];
                break;
            case Direction::↖:
                --$segment['x'];
                --$segment['y'];
                break;
            case Direction::⬆;
                --$segment['y'];
                break;
            case Direction::↗;
                ++$segment['x'];
                --$segment['y'];
                break;
            case Direction::➡;
                ++$segment['x'];
                break;
            case Direction::↘:
                ++$segment['x'];
                ++$segment['y'];
                break;
            case Direction::⬇;
                ++$segment['y'];
                break;
            case Direction::↙:
                --$segment['x'];
                ++$segment['y'];
        }
    }


    /**
     * @param array $head ['x','y']
     * @param array $tail ['x','y']
     * @return void
     */
    private function follow(array $head, array &$tail): void
    {
        $dx = $head['x'] - $tail['x'];
        $dy = $head['y'] - $tail['y'];


        if ($dy === -2 && $dx === 0) {
            $this->move($tail, Direction::⬆);
        }
        if ($dy === 0 && $dx === -2) {
            $this->move($tail, Direction::←);
        }
        if ($dy === 2 && $dx === 0) {
            $this->move($tail, Direction::⬇);
        }
        if ($dy === 0 && $dx === 2) {
            $this->move($tail, Direction::➡);
        }
        if (($dy === 1 && $dx === 2) ||
            ($dy === 2 && $dx === 1) ||
            ($dy === 2 && $dx === 2)) {
            $this->move($tail, Direction::↘);
        }
        if (($dy === 1 && $dx === -2) ||
            ($dy === 2 && $dx === -1) ||
            ($dy === 2 && $dx === -2)) {
            $this->move($tail, Direction::↙);
        }
        if (($dy === -1 && $dx === -2) ||
            ($dy === -2 && $dx === -1) ||
            ($dy === -2 && $dx === -2)) {
            $this->move($tail, Direction::↖);
        }
        if (($dy === -1 && $dx === 2) ||
            ($dy === -2 && $dx === 1) ||
            ($dy === -2 && $dx === 2)) {
            $this->move($tail, Direction::↗);
        }


    }


    /**
     * @return int 6498
     */
    public function PartOne(): int
    {
        $visits_t['0,0'] = 1;
        $visits_9['0,0'] = 1;
        $rope = [];
        for ($i = 0; $i <= 9; $i++) {
            $rope += [$i => ['x' => 0, 'y' => 0]];
        }

        while ($this->input_file->eof() === false) {
            $input = $this->input_file->fgets();
            $input = trim($input);
            $parts = explode(' ', $input);
            [$direction, $repetitions] = $parts;

            for ($i = 0; (int)$repetitions > $i; $i++) {

                $this->move($rope[0], $this->input_direction_mapper[$direction]);

                foreach ($rope as $key => $segment) {
                    if ($key === 0) {
                        $memory = &$rope[$key];
                    } else {
                        $head = &$memory;
                        $tail = &$rope[$key];

                        $this->follow($head, $tail);
                        $memory = &$rope[$key];
                    }
                }

                $visits_t["{$rope[1]['x']},{$rope[1]['y']}"] = 1;
                $visits_9["{$rope[9]['x']},{$rope[9]['y']}"] = 1;
            }
        }

        $this->sum_b = array_sum($visits_9);
        return array_sum($visits_t);
    }


    /**
     * @return int 2531
     */
    public function PartTow(): int
    {
        return $this->sum_b;
    }
}