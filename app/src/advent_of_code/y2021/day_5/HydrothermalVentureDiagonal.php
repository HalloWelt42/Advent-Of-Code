<?php


namespace aoc\advent_of_code\y2021\day_5;


use aoc\advent_of_code\y2021\day_5\helper\Field2d;
use SplFileObject;


class HydrothermalVentureDiagonal
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

    $this->field_2d->draw_line($a[0], $a[1], $b[0], $b[1]);

  }


}