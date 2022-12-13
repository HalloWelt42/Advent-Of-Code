<?php

namespace aoc\advent_of_code\y2022\day_8;

use aoc\advent_of_code\AoC;

class TreetopTreeHouse implements AoC
{

    private array $forest;
    private array $tree_visible;
    private int   $sum_a;
    private int   $sum_b;
    private int   $max_horizontal_index;
    private int   $max_vertical_index;

    public function __construct(string $file)
    {
        $this->forest = explode(PHP_EOL, file_get_contents($file));
        foreach ($this->forest as $tree_pos => $tree_line) {
            $this->tree_visible[$tree_pos] = array_fill(0, strlen($tree_line), 0);
            $this->forest[$tree_pos]       = str_split($tree_line);
        }
        $this->sum_a                = 0;
        $this->sum_b                = 0;
        $this->max_horizontal_index = count($this->forest) - 1;
        $this->max_vertical_index   = count($this->forest[0]) - 1;

    }

    private function getScenicScore(int $y, int $x): int
    {
        $distance = 0;
        // look for trees on the left border
        while ($x - $distance > 0) {
            $distance++;
            if ($this->forest[$y][$x - $distance] >= $this->forest[$y][$x]) {
                break;
            }
        }
        $scenic_score = $distance;

        $distance = 0;
        // look for trees on the top border
        while ($y - $distance > 0) {
            $distance++;
            if ($this->forest[$y - $distance][$x] >= $this->forest[$y][$x]) {
                break;
            }
        }
        $scenic_score *= $distance;

        $distance = 0;
        // look for trees on the right border
        while ($x + $distance < $this->max_vertical_index) {
            $distance++;
            if ($this->forest[$y][$x + $distance] >= $this->forest[$y][$x]) {
                break;
            }
        }
        $scenic_score *= $distance;

        $distance = 0;
        // look for trees on the right border
        while ($y + $distance < $this->max_horizontal_index) {
            $distance++;
            if ($this->forest[$y + $distance][$x] >= $this->forest[$y][$x]) {
                break;
            }
        }
        $scenic_score *= $distance;

        return $scenic_score;
    }

    public function PartOne(): int
    {

        for ($vertical = 1; $this->max_vertical_index > $vertical; $vertical++) {
            $from_left   = $this->forest[$vertical][0];
            $from_right  = $this->forest[$vertical][$this->max_horizontal_index];
            $from_top    = $this->forest[0][$vertical];
            $from_bottom = $this->forest[$this->max_vertical_index][$vertical];
            for ($horizontal = 1; $this->max_horizontal_index > $horizontal; $horizontal++) {

                // left 2 right
                $tree_right = $this->forest[$vertical][$horizontal];
                if ($from_left < 9 && $from_left < $tree_right) {
                    $from_left                                  = $tree_right;
                    $this->tree_visible[$vertical][$horizontal] = 1;
                }

                // right 2 left
                $tree_left = $this->forest[$vertical][$this->max_horizontal_index - $horizontal];
                if ($from_right < 9 && $from_right < $tree_left) {
                    $from_right                                                               = $tree_left;
                    $this->tree_visible[$vertical][$this->max_horizontal_index - $horizontal] = 1;
                }

                // top 2 bottom
                $tree_bottom = $this->forest[$horizontal][$vertical];
                if ($from_top < 9 && $from_top < $tree_bottom) {
                    $from_top                                   = $tree_bottom;
                    $this->tree_visible[$horizontal][$vertical] = 1;
                }

                // bottom
                $tree_top = $this->forest[$this->max_horizontal_index - $horizontal][$vertical];
                if ($from_bottom < 9 && $from_bottom < $tree_top) {
                    $from_bottom                                                              = $tree_top;
                    $this->tree_visible[$this->max_horizontal_index - $horizontal][$vertical] = 1;
                }

                // part 2
                if (($score = $this->getScenicScore($vertical, $horizontal)) > $this->sum_b) {
                    $this->sum_b = $score;
                }

            }
        }

        $this->sum_a = $this->max_horizontal_index * 4;
        foreach ($this->tree_visible as $trees) {
            $this->sum_a += array_sum($trees);
        }


        return $this->sum_a;
    }

    public function PartTow(): int
    {
        return $this->sum_b;
    }
}