<?php
class Player extends GameException implements PlayerInterface {

  public $name;
  public $sign;
  public $color;
  private $board;

  public function __construct(string $name)
  {
      $this->name = $name;
  }

  public function makeMove(Board $board)
  {
      $this->board = $board;

      $input = trim(fgets(STDIN));

      return $this->board->update($this->sign, $input);
  }

  public function isHuman():bool
  {
      return true;
  }
}
