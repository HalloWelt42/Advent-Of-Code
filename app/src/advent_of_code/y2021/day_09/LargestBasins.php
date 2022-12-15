<?php declare(strict_types=1);


namespace aoc\advent_of_code\y2021\day_09;


use aoc\advent_of_code\y2021\day_09\helper\Map;
use aoc\advent_of_code\y2021\day_09\helper\Valley;
use SplFileObject;


/**
 *  * https://adventofcode.com/2021/day/9
 *
 * Class SmokeBasin
 * @package aoc\advent_of_code\y2021\day_09
 */
class LargestBasins
{


  private Map $basin_map;
  private Map $shaddow_map;


  public function __construct()
  {

    // Konfiguration
//    $file = __DIR__ . '/example_input.txt';
    $file            = __DIR__ . '/input.txt';
    $file_operation = new SplFileObject($file);
    $map            = [];
    $zones          = [];
    $high_zones     = [];
    /**
     * @var $valleys Valley[]
     */
    $valleys = [];

    // Datei laden
    while ($data = trim($file_operation->fgets())) {

      // Eine Zeile der Map mit einzelnen Werten
      $list = [];
      foreach (str_split($data) as $item) {
        $list[] = (int)$item;
      }
      $map[] = $list;

    }

    $this->basin_map   = new Map($map);
    $this->shaddow_map = new Map($map);
    $this->shaddow_map->resetVal();


    // Täler ermitteln
    for ($y = 0; $this->basin_map->getMaxY() > $y; $y++) {
      for ($x = 0; $this->basin_map->getMaxX() > $x; $x++) {

        $neighbors = [];
        foreach ([
                   [0, -1], // top
                   [0, 1], // bottom
                   [-1, 0], // left
                   [1, 0], // right
                 ] as $coords) {
          $x0     = $coords[0];
          $y0     = $coords[1];
          $height = $this->basin_map->getFieldFromMap($x0 + $x, $y0 + $y);

          // gültige Koordinaten-Werte aufnehmen
          if ($height !== NULL) {
            $neighbors[] = $height;
          }

        }

        $height = $this->basin_map->getFieldFromMap($x, $y);
        if (min($neighbors) > $height) {
          $valleys[] = new Valley($x, $y, $height);
        }

      }

    }

    // Tal-Zone suchen
    foreach ($valleys as $valley) {
      $this->shaddow_map->resetSetCounter();
      $this->neighbour4($valley->getX(), $valley->getY(), 0, 1);
      $zones[] = $this->shaddow_map->getSetCounter();
    }

    // 3 größte Täler
    sort($zones);
    $count        = count($zones);
    $high_zones[] = $zones[$count - 3];
    $high_zones[] = $zones[$count - 2];
    $high_zones[] = $zones[$count - 1];


    // Ausgabe
    print_r($high_zones[0] * $high_zones[1] * $high_zones[2]);
    print_r(PHP_EOL);

  }


  /**
   * Angelehnt an : Floodfill
   *  https://de.wikipedia.org/wiki/Floodfill#4-connected_oder_4-Neighbour
   *
   * @param int $x
   * @param int $y
   * @param int $old
   * @param int $new
   */
  private function neighbour4(int $x, int $y, int $old, int $new)
  {
    if (
      $this->basin_map->getFieldFromMap($x, $y) < 9
      && $this->shaddow_map->getFieldFromMap($x, $y) === 0
    ) {
      // set
      $this->shaddow_map->setFieldFromMap($x, $y, $new);
      $this->neighbour4($x, $y + 1, $old, $new);
      $this->neighbour4($x, $y - 1, $old, $new);
      $this->neighbour4($x + 1, $y, $old, $new);
      $this->neighbour4($x - 1, $y, $old, $new);
    }
  }


  /**
   * Debugging Helper
   *
   * @param array $map
   */
  private function showMap(array $map)
  {
    foreach ($map as $y => $item) {
      foreach ($item as $x => $value) {
        print_r($value);
      }
      print_r(PHP_EOL);
    }
  }

}