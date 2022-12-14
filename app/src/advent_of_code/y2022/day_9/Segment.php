<?php

namespace aoc\advent_of_code\y2022\day_9;

class Segment
{
    private int      $x;
    private int      $y;
    private string   $name;
    private ?Segment $child;

    public function __construct(string $name, Segment $child = null)
    {
        $this->x     = 0;
        $this->y     = 0;
        $this->name  = $name;
        $this->child = $child;
    }

    public function moveChildSegment(): void
    {
        if ($this->child !== null) {

            $segment_x = $this->x;
            $segment_y = $this->y;
            $child_x   = $this->child->getX();
            $child_y   = $this->child->getY();

            if ($segment_x - $child_x === 2) {
                $this->child->setX($this->child->getX() + 1);
                $this->child->setY($segment_y);
                return;
            }

            if ($segment_x - $child_x === -2) {
                $this->child->setX($this->child->getX() - 1);
                $this->child->setY($segment_y);
                return;
            }

            if ($segment_y - $child_y === 2) {
                $this->child->setY($this->child->getY() + 1);
                $this->child->setX($segment_x);
                return;
            }

            if ($segment_y - $child_y === -2) {
                $this->child->setY($this->child->getY() - 1);
                $this->child->setX($segment_x);
            }

            $this->child->moveChildSegment();
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

    public function setX(int $x): void
    {
        $this->x = $x;
    }

    public function setY(int $y): void
    {
        $this->y = $y;
    }

    private function hasChild(): bool
    {
        return $this->child !== null;
    }

    public function findNode($name): ?Segment
    {
        if ($this->name === $name) {
            return $this;
        }

        if ($this->hasChild()) {
            return $this->child->findNode($name);
        }

        return null;
    }

}