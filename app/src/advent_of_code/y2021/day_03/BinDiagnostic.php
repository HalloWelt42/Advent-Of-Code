<?php


namespace aoc\advent_of_code\y2021\day_03;

use aoc\advent_of_code\Y2021\day_03\helper\DualCounter;
use SplFileObject;

/**
 * https://adventofcode.com/2021/day/3 part 2
 *
 * Class BinDiagnostic
 * @package aoc\advent_of_code\y2021\day_03
 */
class BinDiagnostic
{

  const OXIGEN_GENERATOR_RATING = 1;
  const CO2_SCRUBBER_RATING     = 0;

  /**
   * Listendaten aus Imports
   *
   * @var array
   */
  private array $binaray_list;


  /**
   * BinDiagnostic constructor.
   */
  public function __construct()
  {

    // Konfiguration
//    $file   = __DIR__ . '/input_example.txt'; // Testdaten aus dem Beispiel
    $file   = __DIR__ . '/input.txt';
    $rating = 1; // Start mit 1 da Multiplikation mit Vorgänger

    // Verarbeitung
    foreach ([self::OXIGEN_GENERATOR_RATING, self::CO2_SCRUBBER_RATING] as $gas) {
      // Eingaben(n)
      $this->import($file);

      // Verarbeitung
      $rating *= $this->calc_rating($gas);
    }

    // Ausgabe
    print_r($rating);
    print_r(PHP_EOL);

  }


  /**
   * Liest die Testdaten aus einer Daten in den Arbeitsspeicher
   * und überschreibt gleichzeitig bestehende Werte
   *
   * @param string $file
   */
  private function import(string $file)
  {
    $file_operation     = new SplFileObject($file);
    $this->binaray_list = [];
    while ($binary = trim($file_operation->fgets())) {
      $this->binaray_list[] = $binary;
    }
  }


  /**
   * Bewertung für CO2(0) und Sauerstoff(1)
   *
   * @param bool $gas CO2(0) oder Sauerstoff(1)
   * @return int Ergebnis
   */
  private function calc_rating(bool $gas): int
  {

    // erstes Binary
    $binary_length = strlen($this->binaray_list[0]);

    // durchlaufen, bis nurnoch ein Binaray in der Liste übrig ist
    while (count($this->binaray_list) > 1) {
      for ($bit_pos = 0; $bit_pos < $binary_length; $bit_pos++) {

        $bit_count  = $this->get_bit_count($this->binaray_list, $bit_pos);
        $delete_bit = $bit_count->getOnes() >= $bit_count->getZeros() ? !$gas : $gas;
        $this->remove($bit_pos, $delete_bit);

        if (count($this->binaray_list) === 1) {
          break;
        }

      }
    }

    $array_key       = array_key_last($this->binaray_list);
    $last_binary_val = $this->binaray_list[$array_key];

    return bindec($last_binary_val);

  }


  /**
   * Zählt die vorkommenden, untereinander stehenden Bits aus der Binärreihen-Liste
   *
   * @param array $bit_list Binärreihen-Liste
   * @param int $pos Bitposition innerhalb der Binärreihe
   * @return DualCounter Container der Bitanzahl jeweils für 0 und 1
   */
  private function get_bit_count(array &$bit_list, int $pos): DualCounter
  {
    $bit_count = new DualCounter();

    // max vorkommen 1 oder 0
    foreach ($bit_list as $bit) {
      $bit_count->addOnes($bit[$pos] ? 1 : 0);
      $bit_count->addZeros($bit[$pos] ? 0 : 1);
    }

    return $bit_count;

  }


  /**
   * Geht jede Binärfolge durch und schaut jedes Bit an,
   * auf dessen Grundlage entschieden wird welche Binärfolge aussortiert (gelöscht) wird
   *
   *
   * @param int $pos Position auf der horizontalen Binärfolge (links -> rechts)
   * @param bool $delete_bit Wert auf der Position (0 oder 1), das entscheidet welche Reihe gelöscht wird
   */
  private function remove(int $pos, bool $delete_bit)
  {

    foreach ($this->binaray_list as $i => $byes) {
      if ($byes[$pos] == $delete_bit) {
        unset($this->binaray_list[$i]);
      }
    }

  }


}