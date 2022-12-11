<?php

namespace aoc\advent_of_code\y2022\day_6;

/**
 * https://adventofcode.com/2022/day/6
 *
 */
class TuningTrouble
{

    private string $signals;

    public function __construct()
    {
        // Eingabe
        $this->signals = trim(file_get_contents(__DIR__ . '/input.txt'));

        // Ausgabe Teil 1 / 1142
        print_r($this->getStartSignalPos(4));
        print_r(PHP_EOL);

        // Ausgabe Teil 2 / 2803
        print_r($this->getStartSignalPos(14));
        print_r(PHP_EOL);
    }


    /**
     * @param int $signal_width
     * @return int
     */
    private function getStartSignalPos(int $signal_width): int
    {
        $signals_count = strlen($this->signals);
        for ($i = 0; $signals_count > ($i + $signal_width); $i++) {
            if (!preg_match('/(.).*\1/', substr($this->signals, $i, $signal_width))) {
                return $i + $signal_width;
            }
        }
        return -1;
    }

}