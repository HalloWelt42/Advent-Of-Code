<?php


namespace aoc\advent_of_code\y2021\day_5;


use aoc\advent_of_code\y2021\day_5\helper\Field2d;
use SplFileObject;


class HydrothermalVenture
{


  private Field2d $field_2d;


  /**
   * HydrothermalVenture constructor.
   */
  public function __construct()
  {

    // Konfiguration
//    $this->field_2d = new Field2d(10, 10, 0);
    $this->field_2d = new Field2d(1000, 1000, 0);

    // Eingabe
//    $fo = new SplFileObject(__DIR__ . '/example_input.txt');
    $fo = new SplFileObject(__DIR__ . '/input.txt');

    // Verarbeitung
    while (($data = trim($fo->fgets()))) {
      $this->read_xy($data);
    }


//    print_r($this->field_2d->show_all());
    print_r($this->field_2d->cross_points());
    print_r(PHP_EOL);

  }


  /**
   * @param string $data
   */
  private function read_xy(string &$data)
  {
    $ab = explode(' -> ', $data);
    $a  = explode(',', $ab[0]);
    $b  = explode(',', $ab[1]);

    // Diagonale Werte aussortieren
    if ($this->check_diagonal($a[0], $a[1], $b[0], $b[1]) === FALSE) {
      return;
    }

    $this->field_2d->draw_line($a[0], $a[1], $b[0], $b[1]);

  }


  /**
   * @param int $x1
   * @param int $y1
   * @param int $x2
   * @param int $y2
   * @return bool
   */
  private function check_diagonal(int $x1, int $y1, int $x2, int $y2)
  {
    if ($x1 === $x2 || $y1 === $y2) {
      return TRUE;
    }

    return FALSE;
  }


}