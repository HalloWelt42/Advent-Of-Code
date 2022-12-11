<?php


namespace aoc\advent_of_code\y2021\day_6;


/**
 * https://adventofcode.com/2021/day/6
 *
 *
 * Class Lanternfish
 * @package aoc\advent_of_code\y2021\day_6
 */
class Lanternfish
{


  private array $counter_box;


  /**
   * Lanternfish constructor.
   */
  public function __construct()
  {

    // Konfiguration
    $this->counter_box       = array_fill(0, 9, 0);
    $file                    = __DIR__ . '/input.txt';


    // Eingabe
    $this->load_initial($file);


    // Ausgabe
    // Lösung : Tag 1
    print_r($this->lanternfish_populations(80) . PHP_EOL);

    // Lösung : Tag 2
    print_r($this->lanternfish_populations(256) . PHP_EOL);

  }


  /**
   * @param int $count
   * @return int Population count
   */
  private function lanternfish_populations(int $count): int
  {
    for ($i = 0; $i < $count; $i++) {
      $this->next_population();
    }
    return array_sum($this->counter_box);
  }


  /**
   * Nächste Population erstellen
   *
   * explanation of the procedure:
   *
   *    *
   *     |-->-------------------------> add     <- jump forward and add at this position
   *     |-->-----------------> add      |
   *     |                       |       |
   *     0   1   2   3   4   5   6   7   8      <- number
   *     x   x   x   x   x   x   x   x   x      <- quality of number 0..9
   *                                 <---       <- move quantity of numbers back a step
   *                             <---
   *                         <---
   *                     <---
   *                 <---
   *             <---
   *         <---
   *     <---
   *
   *
   * example:
   *    Problemanalyse
   *
   *                                            0   1   2   3   4   5   6   7   8  <- Werte
   *                                            ---------------------------------
   * Initial state: 3,4,3,1,2                   0   1   1   2   1   0   0   0   0  <- Anzahl der Werte
   * After  1 day:  2,3,2,0,1                  [1]  1   2   1   0   0   0   0   0
   * After  2 days: 1,2,1,6,0,8                [1]  2   1   0   0   0  [1]  0  [1] <- addiere Vortagsmenge aller 0er-Werte bei 8er-Werte
   * After  3 days: 0,1,0,5,6,7,8              [2]  1   0   0   0   1  [1]  1  [1]    und ersetze alle 6er-Werte aus 0er-Werten der Vortagsmenge
   * After  4 days: 6,0,6,4,5,6,7,8,8          [1]  0   0   0   1   1  [3]  1  [2]
   * After  5 days: 5,6,5,3,4,5,6,7,7,8         0   0   0   1   1   3  [2]  2  [1]
   * ...
   *
   *
   */
  private function next_population()
  {

    $new_population = $this->counter_box[0] ?: 0;

    // left shift
    for ($i = 0; $i < 8; $i++) {
      $this->counter_box[$i] = $this->counter_box[$i + 1];
    }

    $this->counter_box[6] += $new_population;
    $this->counter_box[8] = $new_population;

  }


  /**
   * load Date from file
   *
   * @param string $file
   */
  private function load_initial(string $file)
  {

    $initial_state_data = file_get_contents($file);
    $initial_state      = explode(',', $initial_state_data);

    foreach ($initial_state as $state) {
      $this->counter_box[$state]++;
    }

    $this->conter_box_initial = $this->counter_box;
  }

}
