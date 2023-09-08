<?php
class GameUi
{

  public function drawGrid(array $grid)
  {
      // Mark for rows and columns to enchance user experience
      $output = "\n       1 2 3\n";
      $i = 1;

      foreach ($grid as $line) {
          $output .= "     $i " . implode( '|', $line) . "\n";
          $i++;
      }
      print($output);
  }

  public function notifyPlayerTurn($name, $sign, $color, bool $isHuman)
  {
      $this->print("\n{$name} ({$sign}) is playing his turn.", $color);

      if ($isHuman) {
          print("Enter position: ");
      }
  }

  public function printGameResult($string)
  {
      $string = "--------------------------\n-     $string    -\n"
          . "--------------------------";

      $this->print($string, 'green');
  }

  public function printException($string)
  {
      $this->print($e, 'red');
  }

  private function print($string, $color)
  {
      $colors = [
        'red'     => '31',
        'yellow'  => '33',
        'green'   => '32',
        'blue'    => '36'
      ];

      print("\033[1;{$colors[$color]}m{$string}\033[0m\n");
  }
}
