<?php

namespace aoc\advent_of_code\y2022\day_9;

use aoc\advent_of_code\AoC;
use SplFileObject;

class RopeBridge implements AoC
{

    private SplFileObject $input_file;


    /**
     * @var Position[]
     */
    private array $directions;

    public function __construct(string $file)
    {
        $this->input_file = new SplFileObject($file);
        $this->directions = [
            'D' => Position::down,
            'U' => Position::up,
            'L' => Position::left,
            'R' => Position::right,
        ];
    }


    /**
     * @param Segment $segment
     * @param string $direction ('U','D','L','R')
     * @return void
     */
    private function move(Segment $segment, string $direction): void
    {
        switch ($this->directions[$direction]) {
            case Position::left;
                $segment->setX($segment->getX() - 1);
                break;
            case Position::right;
                $segment->setX($segment->getX() + 1);
                break;
            case Position::up;
                $segment->setY($segment->getY() - 1);
                break;
            case Position::down;
                $segment->setY($segment->getY() + 1);
        }
    }

    /**
     * @return int 6498
     */
    public function PartOne(): int
    {
        $visits['0,0'] = 1;

        $rope_HT = new Segment('H',
            new Segment('T')
        );

        while ($this->input_file->eof() === false) {
            $bash_command = $this->input_file->fgets();
            $input        = trim($bash_command);
            $parts        = explode(' ', $input);
            [$direction, $repetitions] = $parts;

            // move the head
            for ($i = 0; (int)$repetitions > $i; $i++) {

                $this->move($rope_HT, $direction);

                $rope_HT->moveChildSegment();

                if (($tail = $rope_HT->findNode('T')) !== null) {
                    $visits["{$tail->getX()},{$tail->getY()}"] = 1;
                }
            }
        }

        return array_sum($visits);
    }

    public function PartTow(): int
    {
        return 0;
    }
}