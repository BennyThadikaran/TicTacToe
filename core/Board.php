<?php
class Board extends GameException {

  public $moves = 0;
  private $grid;

  public function __construct()
  {
      $this->grid = [
        ['_','_','_'], ['_','_','_'], ['_','_','_']
      ];
  }

  public function getGrid():array
  {
      return $this->grid;
  }

  public function update($sign, $input):int
  {
      if (! ctype_digit($input) || strlen($input) !== 2) {
          throw new GameException('Position must be 2 digits. Try again.');
      }

      list($x, $y) = str_split($input);

      // Grid index starts at 1 to make it easier for non programmers
      // convert it to zero index.
      $x -= 1;
      $y -= 1;

      if (! isset($this->grid[$x][$y])) {
          throw new GameException('Not a valid cell. Try again.');
      }

      if ($this->grid[$x][$y] !== '_') {
          throw new GameException('Position already taken. Try again');
      }

      $this->grid[$x][$y] = $sign;
      $this->moves += 1;
      return $this->evaluate($this->grid);
  }

  private function evaluate($grid):int
  {
      if ($grid[0][0] !== '_') {
          // First row
          if ($grid[0][0] === $grid[0][1] && $grid[0][1] === $grid[0][2]) {
              return 1;
          }

          // First column
          if ($grid[0][0] === $grid[1][0] && $grid[1][0] === $grid[2][0]) {
              return 1;
          }

          // Diagonal left to right
          if ($grid[0][0] === $grid[1][1] && $grid[1][1] === $grid[2][2]) {
              return 1;
          }
      }

      if ($grid[1][1] !== '_') {
          // Middle row
          if ($grid[1][0] === $grid[1][1] && $grid[1][1] === $grid[1][2]) {
              return 1;
          }

          // Middle column
          if ($grid[0][1] === $grid[1][1] && $grid[1][1] === $grid[2][1]) {
              return 1;
          }

          // Diagonal right to left
          if ($grid[0][2] === $grid[1][1] && $grid[1][1] === $grid[2][0]) {
              return 1;
          }
      }

      if ($grid[2][2] !== '_') {
          // Last row
          if ($grid[2][0] === $grid[2][1] && $grid[2][1] === $grid[2][2]) {
              return 1;
          }

          // Last column
          if ($grid[0][2] === $grid[1][2] && $grid[1][2] === $grid[2][2]) {
              return 1;
          }
      }

      if ($this->moves === 9) {
          return 0;
      }

      return -1;
  }
}
