<?php

namespace aoc\advent_of_code\y2022\day_11;

use aoc\advent_of_code\AoC;
use SplFileObject;

/**
 * https://adventofcode.com/2022/day/11
 *
 */
class MonkeyInTheMiddle implements AoC
{

    private SplFileObject $input_file;
    private int           $sum_b;
    /**
     * @var Monkey[]
     */
    private array  $monkeys;
    private Monkey $monkey;


    public function __construct(string $file)
    {
        $this->input_file = new SplFileObject($file);
        $this->sum_b      = 0;
        $this->monkeys    = [];
    }

    public function PartOne(): int
    {

        // construct monkey-list
        while ($this->input_file->eof() === false) {

            // read monkey properties
            $bash_command = $this->input_file->fgets();
            $input        = trim($bash_command);

            // add a monkey in a list of monkeys
            if (preg_match('/^Monkey (\d+):$/i', $input, $matches)) {
                $this->monkey               = new Monkey($this->monkeys);
                $this->monkeys[$matches[1]] = $this->monkey;
            }

            if (preg_match('/Starting items: (.*)/i', $input, $matches)) {
                $this->monkey->items = explode(', ', $matches[1]);
            }

            if (preg_match('/Operation: new = old (\*|\+) (old|\d+)/i', $input, $matches)) {
                $this->monkey->operation     = [
                    '+' => Operation::add,
                    '*' => Operation::multiplication,
                ][$matches[1]];
                $this->monkey->operation_val = $matches[2];
            }

            if (preg_match('/Test: divisible by (\d+)/i', $input, $matches)) {
                $this->monkey->divisible_by = $matches[1];
            }

            if (preg_match('/If true: throw to monkey (\d+)/i', $input, $matches)) {
                $this->monkey->monkey_true_id = $matches[1];
            }

            if (preg_match('/If false: throw to monkey (\d+)/i', $input, $matches)) {
                $this->monkey->monkey_false_id = $matches[1];
            }

        }

        for ($rounds = 0; 20 > $rounds; $rounds++) {
            foreach ($this->monkeys as $monkey) {
                $monkey->playARound();
            }
        }

        $monkey_inspections = [];
        foreach ($this->monkeys as $id => $monkey) {
            $monkey_inspections += [$id => $monkey->inspections_count];
        }

        sort($monkey_inspections);
        return $monkey_inspections[count($monkey_inspections)-1] * $monkey_inspections[count($monkey_inspections)-2];
    }

    public function PartTow(): int
    {
        return $this->sum_b;
    }
}