<?php


namespace aoc\advent_of_code\y2021\day_9\helper;


class Map
{


  private array $map;
  private int   $x_max;
  private int   $y_max;
  private int   $x_last_index;
  private int   $y_last_index;
  private int   $set_counter;


  public function __construct(array $map)
  {
    $this->x_max        = 0;
    $this->y_max        = 0;
    $this->x_last_index = 0;
    $this->y_last_index = 0;
    $this->set_counter  = 0;
    $this->map          = $map;
    $this->x_max        = count($this->map[0]);
    $this->y_max        = count($this->map);
    $this->x_last_index = $this->x_max - 1;
    $this->y_last_index = $this->y_max - 1;
  }


  /**
   * gesamte Map zurückgeben
   *
   * @return array
   */
  public function getMap(): array
  {
    return $this->map;
  }


  /**
   * gibt einen Wert der Map zurück
   *
   * @param int $x horizontal
   * @param int $y vertical
   * @return int|null value (null = out of range)
   *
   */
  public function getFieldFromMap(int $x, int $y): ?int
  {
    if (!$this->chkFieldFromMap($x, $y)) {
      return NULL;
    }

    return $this->map[$y][$x];
  }


  /**
   * @param int $x
   * @param int $y
   * @param int $height
   * @return self
   */
  public function setFieldFromMap(int $x, int $y, int $height): self
  {
    if (!$this->chkFieldFromMap($x, $y)) {
      return $this;
    }
    $this->map[$y][$x] = $height;
    $this->set_counter++;
    return $this;
  }


  /**
   * prüft die Feldgrenze
   *
   * @param int $x
   * @param int $y
   * @return int
   */
  private function chkFieldFromMap(int $x, int $y): int
  {
    if (
      $x > $this->x_last_index
      || $y > $this->y_last_index
      || $x < 0
      || $y < 0
    ) {
      return FALSE;
    }

    return TRUE;

  }


  /**
   * @return int
   */
  public function getMaxY(): int
  {
    return $this->y_max;
  }


  /**
   * @return int
   */
  public function getMaxX(): int
  {
    return $this->x_max;
  }


  public function resetVal()
  {
    foreach ($this->map as $y => $item) {
      foreach ($item as $x => $val) {
        $this->map[$y][$x] = 0;
      }
    }
  }


  /**
   * @return int
   */
  public function getSetCounter(): int
  {
    return $this->set_counter;
  }


  public function resetSetCounter()
  {
    $this->set_counter = 0;
  }

}