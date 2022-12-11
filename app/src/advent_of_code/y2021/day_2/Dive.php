<?php


namespace aoc\advent_of_code\y2021\day_2;


use SplFileObject;


/**
 * https://adventofcode.com/2021/day/2
 *
 * Class Dive
 * @package aoc\advent_of_code\y2021\day_2
 */
class Dive
{

  /**
   * U-Boot
   * Auswerten der Navigationsdaten (input.txt)
   *
   * Dive constructor.
   */
  public function __construct()
  {

    // Eingabe
    $file           = __DIR__ . '/input.txt';
    $file_operation = new SplFileObject($file);

    // Konfiguration / Ausgangswerte
    $direction_size_horizontal = 0;
    $direction_size_deep       = 0;

    // Verarbeitung
    while ($navigator = $file_operation->fgets()) {

      $data      = explode(' ', trim($navigator));
      $direction = (string)$data[0];
      $units     = (int)$data[1];

      switch ($direction) {
        case 'forward': // Vorwärtsbewegung
          $direction_size_horizontal += $units;
          break;
        case 'down': // Boot taucht mehr ab, Tiefe im Wasser nimm zu
          $direction_size_deep += $units;
          break;
        case 'up': // Boot taucht mehr auf Tiefe im Wasser nimmt ab
          $direction_size_deep -= $units;
      }

    }

    // Ausgabe
    print_r($direction_size_horizontal * $direction_size_deep);
    print_r(PHP_EOL);

  }
}