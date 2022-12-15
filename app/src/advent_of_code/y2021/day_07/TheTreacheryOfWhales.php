<?php


namespace aoc\advent_of_code\y2021\day_07;


class TheTreacheryOfWhales
{

  private array $pos_data;

  public function __construct()
  {

    // Konfiguration
    $this->pos_data   = [];


    // input
//    $file = __DIR__ . '/example_input.txt';
    $file = __DIR__ . '/input.txt';
    $this->load_positions($file);


    // Median
    sort($this->pos_data);
    $count  = count($this->pos_data);
    $median = $this->pos_data[intdiv($count, 2)];

    $fuel = 0;
    foreach ($this->pos_data as $val) {
      $fuel += abs($median - $val);
    }


    $max = max($this->pos_data);
    $min = min($this->pos_data);

    $fuel_gauss = array_fill(0, $max, 0);

    for ($i = $min; $i < $max; $i++) {
      foreach ($this->pos_data as $pos) {
        $n              = abs($pos - $i);
        $fuel_gauss[$i] += intdiv(($n * $n) + $n, 2);
      }
    }

    $min = min($fuel_gauss);


    // Ausgabe Teil 1
    print_r($fuel);
    print_r(PHP_EOL);

    // Ausgabe Teil 2
    print_r($min);
    print_r(PHP_EOL);


  }

  /**
   * @param string $file
   */
  private function load_positions(string $file)
  {
    $pos_data       = file_get_contents($file);
    $this->pos_data = explode(',', $pos_data);
  }


}