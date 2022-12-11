<?php


namespace aoc\advent_of_code\y2021\day_10;


use SplFileObject;

class SyntaxScoring
{


  public function __construct()
  {

    $file = __DIR__ . '/input.txt';
//    $file = __DIR__ . '/example_input.txt';

    $this->solve_day_1($file);
    $this->solve_day_2($file);

  }


  /**
   * @param string $input_file
   * @return void
   */
  private function solve_day_1(string $input_file)
  {

    $file_operator = new SplFileObject($input_file);

    $sum = 0;
    while ($data = trim($file_operator->fgets())) {

      $illegal_char = $this->chk($data);

      // Punktebewertung
      switch ($illegal_char) {
        case ')' :
          $sum += 3;
          break;
        case ']' :
          $sum += 57;
          break;
        case '}' :
          $sum += 1197;
          break;
        case '>' :
          $sum += 25137;
          break;
      }

    }

    print_r($sum);
    print_r(PHP_EOL);

  }


  /**
   * @param string $input_file
   * @return void
   */
  private function solve_day_2(string $input_file)
  {
    $sums          = [];
    $file_operator = new SplFileObject($input_file);

    while ($data = trim($file_operator->fgets())) {


      $this->del_pais($data);

      $part = $this->chk_missed($data);
      if($part === 0){
        continue;
      }
      $sums[] = $part;

    }

    sort($sums);
    $median = intdiv(count($sums), 2);

    print_r($sums[$median]);
    print_r(PHP_EOL);

  }

  /**
   * @param string $data
   * @return int
   */
  private function chk_missed(string $data): int
  {

    $part = 0;
    foreach (array_reverse(str_split($data)) as $val) {

      $part *= 5;
      switch ($val) {
        case '(':
          $part++;
          break;
        case '[':
          $part += 2;
          break;
        case '{':
          $part += 3;
          break;
        case '<':
          $part += 4;
          break;
        case ')':
        case ']':
        case '}':
        case '>':
          return 0;
      }
    }
    return $part;
  }


  /**
   * Ersten fehlenden Zeichen
   *
   * @param string $data
   * @return string
   */
  private function chk(string $data): string
  {
    $this->del_pais($data);
    $this->del_left($data);

    if (strlen($data) > 0) {
      return $data[0];
    } else {
      return '';
    }

  }


  /**
   * @param string $data
   * @return void
   */
  private function del_pais(string &$data)
  {
    $len_2 = 1;
    while ($len_2 != 0) {
      $len_1 = strlen($data);
      $data  = str_replace(['()', '[]', '{}', '<>'], '', $data);
      $len_2 = $len_1 - strlen($data);
    }
  }

  /**
   * @param string $data
   * @return void
   */
  private function del_left(string &$data)
  {
    $len_2 = 1;
    while ($len_2 != 0) {
      $len_1 = strlen($data);
      $data  = str_replace(['(', '[', '{', '<'], '', $data);
      $len_2 = $len_1 - strlen($data);
    }
  }


}



