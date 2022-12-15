<?php


namespace aoc\advent_of_code\y2021\day_08;


use aoc\advent_of_code\y2021\day_08\helper\Segment7;
use SplFileObject;


/**
 * https://adventofcode.com/2021/day/8
 *
 * Class SevenSegmentSearch
 * @package aoc\advent_of_code\y2021\day_08
 */
class SevenSegmentSearchPart2
{


  public function __construct()
  {


    // Konfiguration
//    $file = __DIR__ . '/example_input.txt';
    $file = __DIR__ . '/input.txt';
    $sum = 0;


    // Eingabe
    $file_operation = new SplFileObject($file);


    // Verarbeitung
    while ($data = trim($file_operation->fgets())) {

      $data_parts       = explode(' | ', $data);
      $test_sequences   = explode(' ', $data_parts[0]); // linker Datenabschnitt
      $target_sequences = explode(' ', $data_parts[1]); // rechter Datenabschnitt

      $segment7 = new Segment7();
      $sum      += $segment7->decodeWireMapping($test_sequences, $target_sequences);

    }

    // Ausgabe
    print_r($sum);
    print_r(PHP_EOL);

  }


}