<?php

namespace aoc\advent_of_code\y2022\day_02\solve_human_readable;

class VotingInputDecoder
{
    public readonly string $elf;
    public readonly string $you;

    public function __construct(string $data)
    {
        $split = explode(' ', trim($data));
        [$this->elf, $this->you] = $split;
    }
}