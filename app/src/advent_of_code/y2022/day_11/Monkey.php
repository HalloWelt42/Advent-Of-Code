<?php

namespace aoc\advent_of_code\y2022\day_11;

class Monkey
{

    /**
     * @var Monkey[]
     */
    private array     $monkeys;
    public array      $items;
    public Operation  $operation;
    public int|string $operation_val;
    public int        $monkey_true_id;
    public int        $monkey_false_id;
    public int        $divisible_by;
    public int        $new;
    public int        $old;
    public int        $inspections_count;

    public function __construct(array &$monkeys)
    {
        $this->monkeys           = &$monkeys;
        $this->inspections_count = 0;
    }

    public function playARound(): void
    {
        foreach ($this->items as $item) {
            $this->old = $item;

            if ($this->operation_val === 'old') {
                $this->new = $this->old * $this->old;
            } else {
                switch ($this->operation) {
                    case Operation::add:
                        $this->new = $this->old + $this->operation_val;
                        break;
                    case Operation::multiplication:
                        $this->new = $this->old * $this->operation_val;
                        break;
                }
            }

            array_shift($this->items);
            $this->new = floor($this->new/3);
            $this->monkeys[$this->throw2Monkey()]->items[] = $this->new;
            $this->inspections_count++;
        }
    }

    private function throw2Monkey(): int
    {
        return
            $this->new % $this->divisible_by === 0
                ? $this->monkey_true_id
                : $this->monkey_false_id;
    }
}