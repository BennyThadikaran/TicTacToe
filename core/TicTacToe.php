<?php
class TicTacToe {

  private $board;
  private $ui;
  private $lastPlayer;
  private $player1;
  private $player2;

  public function __construct(
      Board $board,
      GameUi $ui,
      PlayerInterface $player1,
      PlayerInterface $player2
  )
  {
      $this->board = $board;
      $this->ui = $ui;

      $player1->sign = 'x';
      $player2->sign = 'o';
      $player1->color = 'yellow';
      $player2->color = 'blue';

      $this->player1 = $player1;
      $this->player2 = $player2;
  }

  public function start()
  {
      $gameState = -1;
      $this->ui->drawGrid($this->board->getGrid());

      while ($gameState === -1) {
          $player = $this->getPlayer();

          $this->ui->notifyPlayerTurn(
              $player->name,
              $player->sign,
              $player->color,
              $player->isHuman()
          );

          try {
              $gameState = $player->makeMove($this->board);
              $this->lastPlayer = $player;
          } catch (\GameException $e) {
              $this->ui->printException($e);
          }

          $this->ui->drawGrid($this->board->getGrid());
      }

      if ($gameState === 0) {
          $this->ui->printGameResult('Game was a draw');
      }

      if ($gameState === 1) {
          $this->ui->printGameResult("{$this->lastPlayer->name} wins the game!!");
      }
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
