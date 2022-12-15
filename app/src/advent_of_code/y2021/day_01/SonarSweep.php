<?php


namespace aoc\advent_of_code\y2021\day_01;


use SplFileObject;


/**
 * https://adventofcode.com/2021/day/1
 *
 * Class SonarSweep
 * @package aoc\advent_of_code\y2021\day_01
 */
class SonarSweep
{

  public function __destruct()
  {

    // Eingabe
    $fo = new SplFileObject(__DIR__ . '/input.txt');

    // Anfangsbedingungen
    $counter = 0;
    $old_val = $fo->fgets();

    // Verarbeitung
    while (($data = $fo->fgets())) {
      if( (int)$data > $old_val ){
        $counter++;
      }
      $old_val = (int)$data;
    }

    // Ausgabe
    print_r($counter);
    print_r(PHP_EOL);

  }

}

