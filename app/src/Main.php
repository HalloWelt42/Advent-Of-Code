<?php

namespace aoc;

require_once __DIR__ . '/../vendor/autoload.php';

class Main
{
    public function __construct()
    {

        $puzzle = [
            'y2022' => [
                'day7'     => new \aoc\advent_of_code\y2022\day_7\NoSpaceLeftOnDevice(__DIR__ . '/advent_of_code/y2022/day_7/input.txt'),
                'day7test' => new \aoc\advent_of_code\y2022\day_7\NoSpaceLeftOnDevice(__DIR__ . '/advent_of_code/y2022/day_7/test_input.txt'),
            ],
        ][$_SERVER['argv'][1]][$_SERVER['argv'][2] . ($_SERVER['argv'][3] ?? '')] ?? null;

        if ($puzzle === null) {
            echo 'no puzzles found' . PHP_EOL;
            exit();
        }

        print_r($puzzle->PartOne() . PHP_EOL);
        print_r($puzzle->PartTow() . PHP_EOL);
    }
}


new Main();



