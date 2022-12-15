<?php


namespace aoc\advent_of_code\y2021\day_08\helper;

/**
 *
 *    .aaaa.
 *    b....c
 *    b....c
 *    .dddd.
 *    e....f
 *    e....f
 *    .gggg.
 *
 *
 * Class Segment7
 * @package aoc\advent_of_code\y2021\day_08\helper
 */
class Segment7
{

  /**
   * Mapping für Verkabelung
   *
   * @var string[]
   */
  private array $wiremap;


  /**
   * Codierung der uneindeutigen Werte
   *
   * @var int[]
   */
  private array $encoding;


  /**
   * Segment7 constructor.
   */
  public function __construct()
  {

    $this->wiremap = [
      'a' => 'abcdefg',
      'b' => 'abcdefg',
      'c' => 'abcdefg',
      'd' => 'abcdefg',
      'e' => 'abcdefg',
      'f' => 'abcdefg',
      'g' => 'abcdefg',
    ];

    // Codiervorschrift für uneindeutige Zahlen
    $this->encoding = [
      'abcefg' => 0,
      'acdeg'  => 2,
      'acdfg'  => 3,
      'abdfg'  => 5,
      'abdefg' => 6,
      'abcdfg' => 9,
    ];

  }


  /**
   * Decodiert falsche Verdrahtung umd ermittelt Ziel-Werte
   *
   * @param array $test_sequences
   * @param array $target_sequences
   * @return int
   */
  public function decodeWireMapping(array $test_sequences, array $target_sequences): int
  {

    $solved = '';

    // pin-Zähler anlegen
    $pin_count = ['a' => 0, 'b' => 0, 'c' => 0, 'd' => 0, 'e' => 0, 'f' => 0, 'g' => 0];

    // eindeutige Zahlen bezüglich Pinanzahl
    $unique_numbers = [1 => '', 7 => '', 4 => ''];

    foreach ($test_sequences as $sequence) {

      // statistische Häufigkeit feststellen
      foreach (str_split($sequence, 1) as $pin) {
        $pin_count[$pin]++;
      }

      // Eindeutige Zahlen rausfischen
      switch (strlen($sequence)) {
        case 2: // 2 Pins = eindeutig Zahl 1
          $unique_numbers[1] = $sequence;
          break;
        case 3: // 3 Pins = eindeutig Zahl 7
          $unique_numbers[7] = $sequence;
          break;
        case 4: // 4 Pins = eindeutig Zahl 4
          $unique_numbers[4] = $sequence;
          break;
      }

    }


    // gezählte Belegung pro Pin durchprüfen um Eindeutigkeit festzustellen
    foreach ($pin_count as $pin => $count) {

      // eindeutige Pins
      switch ($count) {
        case 4: // kann nur e-pin sein
          $this->delExcludedPins('e', $pin);
          break;
        case 6: // kann nur b-pin sein
          $this->delExcludedPins('b', $pin);
          break;
        case 9: // kann nur f-pin sein
          $this->delExcludedPins('f', $pin);
          break;
      }

    }


    // Eindeutig Pin c über Zahl 1
    $is = str_replace($this->wiremap['f'], '', $unique_numbers[1]);
    $this->delExcludedPins('c', $is);

    // Eindeutig Pin a über Zahl 7
    $is = str_replace([$this->wiremap['f'], $this->wiremap['c']], '', $unique_numbers[7]);
    $this->delExcludedPins('a', $is);

    // Eindeutig Pin a über Zahl 4
    $is = str_replace([$this->wiremap['f'], $this->wiremap['c'], $this->wiremap['b']], '', $unique_numbers[4]);
    $this->delExcludedPins('d', $is);


    //
    foreach ($target_sequences as $sequence) {
      $solved .= $this->translater($sequence);
    }


    return (int)$solved;
  }


  /**
   * entferne pin-Zuordnung in der Map welche ausgeschlossen sind
   *
   * @param string $must_pin Eindeutige Zuordnung
   * @param string $is_pin Aktuelle Zuordnung
   */
  private function delExcludedPins(string $must_pin, string $is_pin): void
  {
    $this->wiremap            = str_replace($is_pin, '', array_diff_key($this->wiremap, [$must_pin => NULL]));
    $this->wiremap[$must_pin] = $is_pin;
  }


  /**
   * Übersetzer
   *  decodiert Verdrahtungsplan mit Hilfe der Map
   *
   * @param string $sequence Eingangspinbelegung
   * @return int Zahlenergebnis
   */
  private function translater(string $sequence): int
  {

    // Eindeutige Werte, werden direkt ausgewertet
    switch (strlen($sequence)) {
      case 2:
        return 1;
      case 3:
        return 7;
      case 4:
        return 4;
      case 7:
        return 8;
    }


    // Mehrdeutige Werte werden über Mapping ermittelt
    $decode_sequence = [];
    foreach (str_split($sequence, 1) as $item) {
      $decode_sequence[] = array_flip($this->wiremap)[$item];
    }

    sort($decode_sequence);

    return $this->encoding[implode($decode_sequence)];

  }


}
