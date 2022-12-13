<?php

namespace aoc\advent_of_code\y2022\day_9;

class Tail
{
    private int   $x;
    private int   $y;
    private array $visits;

    public function __construct()
    {
        $this->visits['0,0'] = 1;
        $this->x             = 0;
        $this->y             = 0;
    }

    public function move2Head(Head $head): void
    {
        $h_x = $head->getX();
        $h_y = $head->getY();
        $t_x = $this->x;
        $t_y = $this->y;

        if ($h_x - $t_x === 2) {
            $this->x++;
            $this->y = $h_y;
            $this->setVisit();
            return;
        }

        if ($h_x - $t_x === -2) {
            $this->x--;
            $this->y = $h_y;
            $this->setVisit();
            return;
        }

        if ($h_y - $t_y === 2) {
            $this->y++;
            $this->x = $h_x;
            $this->setVisit();
            return;
        }

        if ($h_y - $t_y === -2) {
            $this->y--;
            $this->x = $h_x;
            $this->setVisit();
        }
    }

    private function setVisit()
    {
        $this->visits["{$this->x},{$this->y}"] = 1;
    }

    public function getX(): int
    {
        return $this->x;
    }

    public function getY(): int
    {
        return $this->y;
    }

    public function getAllVisits(): int
    {
        return array_sum($this->visits);
    }

}