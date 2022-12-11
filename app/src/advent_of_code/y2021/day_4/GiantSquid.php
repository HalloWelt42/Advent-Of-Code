<?php


namespace aoc\advent_of_code\y2021\day_4;

use SplFileObject;


/**
 * https://adventofcode.com/2021/day/4
 *
 * Class GiantSquid
 * @package aoc\advent_of_code\y2021\day_4
 */
class GiantSquid
{


  private array $numbers;
  private array $number_fields;
  private array $checked_fields;
  private int   $winner_board_id;
  private int   $won_number_pos;


  /**
   * GiantSquid constructor.
   */
  public function __construct()
  {

    // Konfiguration
    $numbers_file = __DIR__ . '/example_bingo_numbers.txt';
    $fields_file  = __DIR__ . '/example_bingo_fields.txt';
//    $numbers_file         = __DIR__ . '/bingo_numbers.txt';
//    $fields_file          = __DIR__ . '/bingo_fields.txt';

    $this->numbers         = [];
    $this->number_fields   = [[]];
    $this->winner_board_id = -1;
    $this->won_number_pos  = -1;


    // Eingabe
    $this->read_numbers($numbers_file);
    $this->read_fields($fields_file);


    // Verarbeitung
    $this->nowSolveBoard();


    // Auswertung
    $won_number  = (int)$this->numbers[$this->won_number_pos];
    $sum         = $this->sumOfAllUnmarkedNumbers($this->winner_board_id);
    $final_score = $won_number * $sum;

    // Ausgabe
    print_r($final_score);
    print_r(PHP_EOL);

  }


  /**
   * zu ziehende Nummern laden
   *
   * @param string $file Dateiname
   */
  private function read_numbers(string $file): void
  {
    $numbers_data  = file_get_contents($file);
    $this->numbers = explode(',', $numbers_data);
  }


  /**
   * Spielfelder laden
   *
   * @param string $file Dateiname
   */
  private function read_fields(string $file): void
  {
    $file_operation = new SplFileObject($file);
    $i              = 0;
    while ($set = $file_operation->fgets()) {

      $this->checked_fields[] = array_fill(0, 25, 0);

      preg_match_all('/[0-9]+/m', $set, $number_set, PREG_PATTERN_ORDER);

      if (count($number_set[0]) === 5) {
        $this->number_fields[$i] = array_merge($this->number_fields[$i], $number_set[0]);
      } else {
        $i++;
        $this->number_fields[] = [];
      }

    }

  }


  /**
   * Kreuze schrittweise alle Zahlen-Tipps aus der Liste in den Feldern an
   * und prüfe bei jedem Durchlauf, ob ein Sieg stattgefunden hat.
   *
   */
  private function nowSolveBoard(): void
  {
    $solved = FALSE;

    foreach ($this->numbers as $number_pos => $number) {

      foreach ($this->number_fields as $board_id => $number_field) {

        foreach ($number_field as $pos => $field) {

          if ((int)$field == (int)$number) {

            $this->checked_fields[$board_id][$pos] = TRUE;

            if ($this->isFieldComplete($board_id) && !$solved) {
              $this->winner_board_id = $board_id;
              $this->won_number_pos  = $number_pos;
              return;
            }

          }

        }

      }

    }

  }


  /**
   * Angekreuzte Felder finden
   *
   * @param int $board_id Aktuelle Feldposition 5 x 5
   * @return bool Gewonnen ja/nein
   */
  private function isFieldComplete(int $board_id): bool
  {

    for ($i = 0; $i < 5; $i += 1) {

      // horizontal
      $horizontal_part = array_slice($this->checked_fields[$board_id], $i * 5, 5);
      if ($this->checkSequence($horizontal_part) === TRUE) {
        return TRUE;
      }

      // vertical
      $vertical_part = [];
      for ($j = 0; $j < 5; $j++) {
        $vertical_part[] = $this->checked_fields[$board_id][$i + ($j * 5)];
      }
      if ($this->checkSequence($vertical_part) === TRUE) {
        return TRUE;
      }

    }

    return FALSE;
  }


  /**
   * Prüft, ob alle übergebenen Felder ausgefüllt sind
   *
   * @param array $part Abschnitt mit gesetzten Feldern
   * @return bool Alles ausgefüllt (ja/nein)
   */
  private function checkSequence(array &$part): bool
  {
    foreach ($part as $pos) {
      if ($pos == 0) {
        return FALSE;
      }
    }
    return TRUE;
  }


  /**
   * Summer aller Zahlen von unmarkierten Feldern
   *
   * @param int $winner_board_id Board-ID
   * @return int sum
   *
   */
  private function sumOfAllUnmarkedNumbers(int &$winner_board_id): int
  {

    $sum = 0;

    foreach ($this->checked_fields[$winner_board_id] as $list_pos => $checkedField) {
      $sum += $checkedField ? 0 : $this->number_fields[$winner_board_id][$list_pos];
    }

    return $sum;

  }


}
