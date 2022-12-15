<?php


namespace aoc\advent_of_code\y2021\day_09\helper;

/**
 * Trait TListOfValleys
 * @package aoc\advent_of_code\y2021\day_09\helper
 */
trait TListOfValleys
{
  /**
   * @param array|null $top list over current
   * @param array $current list
   * @param array|null $bottom list under current
   * @return array
   */
  private function ListOfValleys(?array $top, array $current, ?array $bottom): array
  {

    $index      = 0;
    $last_index = count($current) - 1;
    $min_list   = [];

    foreach ($current as $item) {

      $values = [];

      if ($top !== NULL) {
        $values[] = (int)$top[$index];
      }

      if ($bottom !== NULL) {
        $values[] = (int)$bottom[$index];
      }

      if ($index > 0) {
        $values[] = (int)$current[$index - 1];
      }

      if ($index < $last_index) {
        $values[] = (int)$current[$index + 1];
      }

      if ((int)$item < min($values)) {
        $min_list[] = (int)$item;
      }

      $index++;
    }

    return $min_list;

  }

}