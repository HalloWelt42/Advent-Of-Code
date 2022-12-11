<?php


namespace aoc\advent_of_code\y2021\day_8;


use SplFileObject;


/**
 * https://adventofcode.com/2021/day/8
 *
 * Class SevenSegmentSearch
 * @package aoc\advent_of_code\y2021\day_8
 */
class SevenSegmentSearch
{

  public function __construct()
  {


    // Konfiguration
//    $file = __DIR__ . '/example_input.txt';
    $file = __DIR__ . '/input.txt';
    $sum  = 0;

    // Eingabe
    $file_operation = new SplFileObject($file);


    // Verarbeitung
    while ($data = trim($file_operation->fgets())) {
      $right = explode(' | ', $data)[1];
      $sum   += $this->count($right);
    }

    // Ausgabe
    print_r($sum);
    print_r(PHP_EOL);

  }


  /**
   * Zähle alle 1er,4er,7er,8er zusammen
   *
   * @param string $segment_code_data Abschnittsdaten 7-Segment
   * @return int Summe
   */
  private function count(string $segment_code_data): int
  {
    $sum               = 0;
    $segment_code_list = explode(' ', trim($segment_code_data));

    foreach ($segment_code_list as $segment) {
      switch (strlen($segment)) {
        case 2: // 1
        case 3: // 7
        case 4: // 4
        case 7: // 8
          $sum++;
      }
    }

    return $sum;
  }


}