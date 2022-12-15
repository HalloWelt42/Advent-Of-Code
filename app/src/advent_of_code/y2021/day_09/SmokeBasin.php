<?php


namespace aoc\advent_of_code\y2021\day_09;


use aoc\advent_of_code\y2021\day_09\helper\TListOfValleys;
use SplFileObject;
use SplQueue;


/**
 *  * https://adventofcode.com/2021/day/9
 *
 * Class SmokeBasin
 * @package aoc\advent_of_code\y2021\day_09
 */
class SmokeBasin
{

  use TListOfValleys;

  public function __construct()
  {

    // Konfiguration
//    $file        = __DIR__ . '/example_input.txt';
    $file        = __DIR__ . '/input.txt';
    $file_object = new SplFileObject($file);
    $parse_data  = new SplQueue();
    $valleys     = [];


    $parse_data->push(trim($file_object->fgets()));
    $parse_data->push(trim($file_object->fgets()));

    // top Area
    $current = str_split($parse_data->offsetGet(0));
    $bottom  = str_split($parse_data->offsetGet(1));
    $valleys = array_merge($valleys, $this->ListOfValleys(NULL, $current, $bottom));

    while ($data = trim($file_object->fgets())) {
      $parse_data->push($data);

      // middle Area
      $top     = str_split($parse_data->offsetGet(0));
      $current = str_split($parse_data->offsetGet(1));
      $bottom  = str_split($parse_data->offsetGet(2));
      $valleys = array_merge($valleys, $this->ListOfValleys($top, $current, $bottom));

      $parse_data->shift();
    }

    // bottom Area
    $top     = str_split($parse_data->offsetGet(0));
    $current = str_split($parse_data->offsetGet(1));
    $valleys = array_merge($valleys, $this->ListOfValleys($top, $current, NULL));


    // Ausgabe
    print_r(count($valleys) + array_sum($valleys));
    print_r(PHP_EOL);

  }




}