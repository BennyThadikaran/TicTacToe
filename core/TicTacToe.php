<?php
class TicTacToe {

  private $board;
  private $lastPlayer;
  private $player1;
  private $player2;

  public function __construct(Board $board, PlayerInterface $player1, PlayerInterface $player2)
  {
      $this->board = $board;

      $player1->sign = 'x';
      $player2->sign = 'o';
      $this->player1 = $player1;
      $this->player2 = $player2;
  }

  public function start()
  {
      $gameState = -1;
      echo $this->board->drawGrid();

      while ($gameState === -1) {
          $player = $this->getPlayer();
          $color = $player->sign === 'o' ? 'blue' : 'yellow';
          $this->print("\n{$player->name} ({$player->sign}) is playing his turn.", $color);

          if ($player->isHuman()) {
              print("Enter position: ");
          }

          try {
              $gameState = $player->makeMove($this->board);
              $this->lastPlayer = $player;
          } catch (\GameException $e) {
              $this->print($e, 'red');
          }

          print( $this->board->drawGrid() );
      }

      if ($gameState === 0) {
          $string = "--------------------------\n-     "
              . "Game was a draw    -\n--------------------------";

          $this->print($string, 'green');
      }

      if ($gameState === 1) {
          $string = "--------------------------\n-     "
            . "{$this->lastPlayer->name} wins the game!!     "
            . "-\n--------------------------";

          $this->print($string, 'green');
      }
  }

  private function print(string $string, string $color)
  {
      $colors = [
        'red'     => '31',
        'yellow'  => '33',
        'green'   => '32',
        'blue'    => '36'
      ];

      print("\033[1;{$colors[$color]}m{$string}\033[0m\n");
  }

  private function getPlayer():PlayerInterface
  {
      // For the first move select a random player
      if ($this->board->moves === 0) {
          return ((rand(0, 1) === 0)
              ? $this->player1
              : $this->player2
          );
      }

      return (($this->lastPlayer === $this->player2)
          ? $this->player1
          : $this->player2
      );
  }
}
