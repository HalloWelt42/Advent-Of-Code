<?php


namespace aoc\advent_of_code\y2021\day_3\helper;


class DualCounter
{

  private int $zeros;
  private int $ones;



  public function __construct()
  {
    $this->zeros = 0;
    $this->ones  = 0;
  }



  /**
   * @return int
   */
  public function getZeros(): int
  {
    return $this->zeros;
  }



  /**
   * @param int $zeros
   * @return DualCounter
   */
  public function addZeros(int $zeros): DualCounter
  {
    $this->zeros += $zeros;
    return $this;
  }



  /**
   * @return int
   */
  public function getOnes(): int
  {
    return $this->ones;
  }



  /**
   * @param int $ones
   * @return DualCounter
   */
  public function addOnes(int $ones): DualCounter
  {
    $this->ones += $ones;
    return $this;
  }






}