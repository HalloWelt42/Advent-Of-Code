<?php

namespace aoc\advent_of_code\y2022\day_05;

use SplFileObject;

/**
 * https://adventofcode.com/2022/day/5
 *
 */
class GiantCargoCrane
{

    private array $ship_cargo_holds;
    private int   $input_data_pos;


    public function __construct()
    {

        $this->ship_cargo_holds = [[], []];
        $this->input_data_pos   = 0;

        // input
        $input_file = new SplFileObject(__DIR__ . '/input.txt');

        $ship_cargo_hold           = $this->buildCargoCrane($input_file);
        $this->ship_cargo_holds[0] = $ship_cargo_hold;
        $this->ship_cargo_holds[1] = $ship_cargo_hold;
        $this->loadTheShips($input_file);

        // output part 1
        print_r($this->getAllTopCargos($this->ship_cargo_holds[0]));
        print_r(PHP_EOL);

        // output part 2
        print_r($this->getAllTopCargos($this->ship_cargo_holds[1]));
        print_r(PHP_EOL);

    }

    /**
     * @param SplFileObject $input_file
     * @return array[]
     */
    private function buildCargoCrane(SplFileObject $input_file): array
    {
        $ship_cargo_hold = [[], [], [], [], [], [], [], []];
        while (($cargos = $input_file->fgets())) {
            // data line 1-8
            $this->input_data_pos++;
            if ($this->input_data_pos < 9) {
                for ($i = 0; 9 > $i; $i++) {
                    $cargo = trim($cargos[($i * 4) + 1]);
                    if ($cargo) {
                        $ship_cargo_hold[$i][8 - $this->input_data_pos] = $cargo;
                    }
                }
            } else {
                foreach ($ship_cargo_hold as $index => $item) {
                    $ship_cargo_hold[$index] = array_reverse($item);
                }
                return $ship_cargo_hold;
            }
        }

        return $ship_cargo_hold;
    }


    /**
     * @param SplFileObject $input_file
     * @return void
     */
    private function loadTheShips(SplFileObject $input_file): void
    {

        while (($move_instructions = $input_file->fgets())) {
            $this->input_data_pos++;

            // dada line 11 - n
            if ($this->input_data_pos > 10) {

                preg_match_all('/\d+/m', $move_instructions, $matches);
                [$moves, $from, $to] = $matches[0];
                $moves = (int)$moves;
                $from  = (int)$from - 1;
                $to    = (int)$to - 1;

                // ship cargo holds 1
                for ($j = 0; $moves > $j; $j++) {
                    $container                        = array_pop($this->ship_cargo_holds[0][$from]);
                    $this->ship_cargo_holds[0][$to][] = $container;
                }

                // ship cargo holds 2
                $container = array_splice($this->ship_cargo_holds[1][$from], -$moves);
                array_push($this->ship_cargo_holds[1][$to], ...$container);

            }
        }
    }


    /**
     * @param array $ship_cargo_hold
     * @return string
     */
    private function getAllTopCargos(array $ship_cargo_hold): string
    {
        $all_top_cargos = '';
        foreach ($ship_cargo_hold as $item) {
            $all_top_cargos .= $item[count($item) - 1];
        }
        return $all_top_cargos;
    }

}