<?php
require 'core/GameException.php';
require 'core/GameUi.php';
require 'core/Board.php';
require 'core/TicTacToe.php';
require 'core/Players/PlayerInterface.php';
require 'core/Players/Player.php';

echo <<<HEADER
*******************************************
*     TicTacToe                           *
*     Developed By Benny Thadikaran       *
*     https://github.com/BennyThadikaran  *
*******************************************\n
HEADER;

// Assign the first player
print("Enter your name? (Player1)\n");
$player1Name = trim(fgets(STDIN));
$player1Name = (empty($player1Name)
    ? 'Player1'
    : $player1Name
);

$player1 = new Player($player1Name);

// Assign the second player
print("Fancy a game with a computer bot? (y)\n");
$useBot = trim(fgets(STDIN));

// Play against AI bot
if (in_array($useBot, ['y', 'Y', ''])) {
    require 'core/Players/Ai.php';
    $player2 = new Ai();
    print("\033[1;36m{$player2->name} joined the game.\033[0m\n\n");
} else {

    // or play another human
    print("Enter the second player's name? (Player2)\n");
    $player2Name = trim(fgets(STDIN));
    $player2Name = (empty($player2Name)
        ? 'Player2'
        : $player2Name
    );

    $player2 = new Player($player2Name);
    print("Welcome {$player1->name} and {$player2->name}\n");
}

echo <<<instructions
-------------------------
-     \033[1;32mInstructions\033[0m      -
-------------------------
The grid consists of 3 rows and 3 columns.\n
       1 2 3
     1 _|_|_
     2 _|_|_
     3 _|_|_\n
To select a cell, type the row and column as\n2 digits and hit enter.

Example: 1st cell is 11 and last cell is 33.\n
\033[1;32mPress enter to begin.\033[0m
instructions;

fgets(STDIN);

// initialize the game
$board = new Board();
$ui = new GameUi();
$game = new TicTacToe($board, $ui, $player1, $player2);

$game->start();
