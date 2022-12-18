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
    /**
     * @var Monkey[]
     */
    private array  $monkeys;
    private Monkey $monkey;

    private string $file;


    /**
     * @param string $file
     */
    public function __construct(string $file)
    {
        $this->file = $file;
    }


    /**
     * @param bool $worry_level
     * @return void
     */
    public function constructMonkeys(bool $worry_level): void
    {

        $input_file                 = new SplFileObject($this->file);
        $this->monkeys              = [];
        $least_common_divisor = 1;


        while ($input_file->eof() === false) {

            // read monkey properties
            $bash_command = $input_file->fgets();
            $input        = trim($bash_command);

            // add a monkey in a list of monkeys
            if (preg_match('/^Monkey (\d+):$/i', $input, $matches)) {
                $this->monkey               = new Monkey($this->monkeys);
                $this->monkey->worry_level  = $worry_level;
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
                $this->monkey->divisible_by = (int)$matches[1];
                $least_common_divisor       *= (int)$matches[1];
            }

            if (preg_match('/If true: throw to monkey (\d+)/i', $input, $matches)) {
                $this->monkey->monkey_true_id = $matches[1];
            }

            if (preg_match('/If false: throw to monkey (\d+)/i', $input, $matches)) {
                $this->monkey->monkey_false_id = $matches[1];
            }

        }

        foreach ($this->monkeys as $monkey) {
            $monkey->least_common_divisor = $least_common_divisor;
        }

    }


    /**
     * @param int $quantity
     * @return void
     */
    private function quantityOfRounds(int $quantity): void
    {
        for ($rounds = 0; $quantity > $rounds; $rounds++) {
            foreach ($this->monkeys as $monkey) {
                $monkey->throwItems();
            }
        }
    }


    /**
     * @return int
     */
    private function getTowBusiestMonkeys(): int
    {
        $monkey_inspections = [];
        foreach ($this->monkeys as $id => $monkey) {
            $monkey_inspections += [$id => $monkey->inspections_count];
        }

        sort($monkey_inspections);

        return
            (int)
            $monkey_inspections[count($monkey_inspections) - 1] *
            $monkey_inspections[count($monkey_inspections) - 2];
    }


    /**
     * @return int
     */
    public function PartOne(): int
    {
        $this->constructMonkeys(true);
        $this->quantityOfRounds(20);
        return $this->getTowBusiestMonkeys();
    }


    /**
     * @return int
     */
    public function PartTow(): int
    {
        $this->constructMonkeys(false);
        $this->quantityOfRounds(10_000);
        return $this->getTowBusiestMonkeys();
    }
}