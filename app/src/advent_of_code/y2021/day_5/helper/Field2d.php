<?php


namespace aoc\advent_of_code\y2021\day_5\helper;


/**
 * https://adventofcode.com/2021/day/5
 *
 * Class Field2d
 * @package aoc\advent_of_code\y2021\day_5\helper
 */
class Field2d
{


  private array $field_2d;


  /**
   * Field2d constructor.
   * @param int $x_max
   * @param int $y_max
   * @param int $start_val
   */
  public function __construct(int $x_max, int $y_max, int $start_val = 0)
  {

    $this->field_2d = array_fill(0, $y_max,
      array_fill(0, $x_max, $start_val)
    );


  }


  /**
   * Helper
   * einen Koordinatenwert zurückgeben
   *
   * @param int $x
   * @param int $y
   * @return int
   */
  public function get(int $x, int $y): int
  {
    return $this->field_2d[$y][$x];
  }


  /**
   * Helper
   * gesamtes Feld zurückgeben
   *
   * @return array
   */
  public function get_all(): array
  {
    return $this->field_2d;
  }


  /**
   * Helper
   * Zeigt alle Felder an
   *
   * @return string
   */
  public function show_all(): string
  {
    $map = '';
    foreach ($this->field_2d as $verticals) {
      $map .= str_replace(0, '.', implode('', $verticals)) . PHP_EOL;
    }
    return $map;
  }


  /**
   * @param int $x1
   * @param int $y1
   * @param int $x2
   * @param int $y2
   */
  public function draw_line(int $x1, int $y1, int $x2, int $y2)
  {
    if ($x1 === $x2) {
      $this->order($y1, $y2);
      $this->draw_y($y1, $y2, $x1);
      return;
    }

    if ($y1 === $y2) {
      $this->order($x1, $x2);
      $this->draw_x($x1, $x2, $y1);
      return;
    }

    $this->draw_xy($x1, $y1, $x2, $y2);

  }


  /**
   * @param int $x1
   * @param int $y1
   * @param int $x2
   * @param int $y2
   */
  private function draw_xy(int $x1, int $y1, int $x2, int $y2)
  {
    $x   = ($x1 < $x2) ? 1 : -1;
    $y   = ($y1 < $y2) ? 1 : -1;
    $max = abs($x2 - $x1);

    for ($i = 0; $i <= $max; $i++) {
      $this->field_2d[$y1 + ($i * $y)][$x1 + ($i * $x)] += ($this->field_2d[$y1 + ($i * $y)][$x1 + ($i * $x)] < 2) ? 1 : 0;
    }
  }


  /**
   * a < b
   *
   * @param int $a
   * @param int $b
   */
  private function order(int &$a, int &$b)
  {
    if ($a > $b) {
      $m = $a;
      $a = $b;
      $b = $m;
    }
  }


  /**
   * Zeichnet eine Vertikal-Linie
   *
   * @param int $a
   * @param int $b
   * @param int $x
   */
  private function draw_y(int $a, int $b, int $x)
  {
    for (; $a <= $b; $a++) {
      $this->field_2d[$a][$x] += ($this->field_2d[$a][$x] < 2) ? 1 : 0;
    }
  }


  /**
   * Zeichnet eine Horizontal-Line
   *
   * @param int $a
   * @param int $b
   * @param int $y
   */
  private function draw_x(int $a, int $b, int $y)
  {
    for (; $a <= $b; $a++) {
      $this->field_2d[$y][$a] += ($this->field_2d[$y][$a] < 2) ? 1 : 0;
    }
  }


  /**
   * Kreuzungspunkte zählen
   *
   * @return int
   */
  public function cross_points(): int
  {
    $n = 0;
    foreach ($this->field_2d as $line) {
      foreach ($line as $val) {
        $n += ($val === 2) ? 1 : 0;
      }
    }
    return $n;
  }


}