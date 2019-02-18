<?php
interface PlayerInterface {
    public function makeMove(Board $board);

    public function isHuman():bool;
}
