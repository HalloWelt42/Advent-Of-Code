<?php


namespace aoc\advent_of_code\y2021\day_9\helper;


class Valley
{
  private int $x;
  private int $y;
  private int $height;

  public function __construct(int $x, int $y, int $height)
  {
    $this->x      = $x;
    $this->y      = $y;
    $this->height = $height;
  }

  /**
   * @return int
   */
  public function getX(): int
  {
    return $this->x;
  }

  /**
   * @return int
   */
  public function getY(): int
  {
    return $this->y;
  }

  /**
   * @return int
   */
  public function getHeight(): int
  {
    return $this->height;
  }


}