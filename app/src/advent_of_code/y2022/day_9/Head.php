<?php

namespace aoc\advent_of_code\y2022\day_9;

class Head
{
    private int  $x;
    private int  $y;
    public function __construct()
    {
        $this->x    = 0;
        $this->y    = 0;
    }

    public function move(Position $position): void
    {
        switch ($position) {
            case Position::left;
                --$this->x;
                break;
            case Position::right;
                ++$this->x;
                break;
            case Position::up;
                --$this->y;
                break;
            case Position::down;
                ++$this->y;
        }
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }
}