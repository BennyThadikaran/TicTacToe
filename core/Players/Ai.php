<?php
class Ai implements PlayerInterface {

  public $name = 'SkyNet';
  public $sign;
  private $opponent;
  private $board;

  public function makeMove(Board $board):int
  {
      $this->board = $board;
      $this->opponent = $this->sign === 'o' ? 'x' : 'o';
      $coord = $this->getBestMove();
      return $this->board->update($this->sign, $coord[0], $coord[1]);
  }

  public function isHuman():bool
  {
      return false;
  }

  private function getBestMove():array
  {
      $bestMove = [];
      $bestValue = -1000;
      $grid = $this->board->getGrid();
      $moves = $this->board->moves;

      for ($i=0; $i < 3; $i++) {
          for ($j=0; $j < 3; $j++) {
              if ($grid[$i][$j] === '_') {
                  $grid[$i][$j] = $this->sign;
                  $value = $this->miniMax($grid, $moves + 1, false);

                  $grid[$i][$j] = '_';

                  if ($value > $bestValue) {
                      $bestMove[0] = $i;
                      $bestMove[1] = $j;
                      $bestValue = $value;
                  }
              }
          }
      }
      return $bestMove;
  }

  private function miniMax(array $grid, int $moves, bool $isMax):int
  {
      $score = $this->evaluate($grid, $moves);

      if ($score !== 1) {
          return $score;
      }

      if ($isMax) {
          $best = -1000;
          for ($i=0; $i < 3; $i++) {
              for ($j=0; $j < 3; $j++) {
                  if ($grid[$i][$j] === '_') {
                      $grid[$i][$j] = $this->sign;
                      $best = max($best, $this->miniMax($grid, $moves + 1, !$isMax));
                      $grid[$i][$j] = '_';
                  }
              }
          }
          return $best;
      } else {
          $best = 1000;
          for ($i=0; $i < 3; $i++) {
              for ($j=0; $j < 3; $j++) {
                  if ($grid[$i][$j] === '_') {
                      $grid[$i][$j] = $this->opponent;
                      $best = min($best, $this->miniMax($grid, $moves + 1, !$isMax));
                      $grid[$i][$j] = '_';
                  }
              }
          }
          return $best;
      }
  }

  private function evaluate(array $grid, int $moves):int
  {
      $score = [
        $this->sign => 10,
        $this->opponent => -10
      ];

      if ($grid[0][0] !== '_') {
          // First row
          if ($grid[0][0] === $grid[0][1] && $grid[0][1] === $grid[0][2]) {
              return $score[ $grid[0][0] ];
          }

          // First column
          if ($grid[0][0] === $grid[1][0] && $grid[1][0] === $grid[2][0]) {
              return  $score[ $grid[0][0] ];
          }

          // Diagonal left to right
          if ($grid[0][0] === $grid[1][1] && $grid[1][1] === $grid[2][2]) {
              return $score[ $grid[0][0] ];
          }
      }

      if ($grid[1][1] !== '_') {
          // Middle row
          if ($grid[1][0] === $grid[1][1] && $grid[1][1] === $grid[1][2]) {
              return $score[ $grid[1][1] ];
          }

          // Middle column
          if ($grid[0][1] === $grid[1][1] && $grid[1][1] === $grid[2][1]) {
              return $score[ $grid[1][1] ];
          }

          // Diagonal right to left
          if ($grid[0][2] === $grid[1][1] && $grid[1][1] === $grid[2][0]) {
              return $score[ $grid[1][1] ];
          }
      }

      if ($grid[2][2] !== '_') {
          // Last row
          if ($grid[2][0] === $grid[2][1] && $grid[2][1] === $grid[2][2]) {
              return $score[ $grid[2][2] ];
          }

          // Last column
          if ($grid[0][2] === $grid[1][2] && $grid[1][2] === $grid[2][2]) {
              return $score[ $grid[2][2] ];
          }
      }

      if ($moves === 9) {
          return 0;
      }

      return 1;
  }
}
