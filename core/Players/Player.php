<?php
class Player extends GameException implements PlayerInterface {

  public $name;
  public $sign;
  private $board;

  public function __construct(string $name)
  {
      $this->name = $name;
  }

  public function makeMove(Board $board)
  {
      $this->board = $board;

      // Row and columns start at 1. Easier for non programmers
      $input = trim(fgets(STDIN));

      if (! ctype_digit($input) || strlen($input) !== 2) {
          throw new GameException('Position must be 2 digits. Try again.');
      }

      $coord = str_split($input);

      // Correct the coordinates for zero index arrays
      return $this->board->update(
          $this->sign,
          $coord[0] - 1,
          $coord[1] - 1
      );
  }

  public function isHuman():bool
  {
      return true;
  }
}
