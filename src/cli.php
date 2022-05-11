<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Dominoes\Board;
use Dominoes\Game;
use Dominoes\Player;

$playersNr =  readline('enter number of players: ');

$players = [];
for ($i = 0; $i < $this->playersNr; $i++) {
            $players[] = new Player();
}
$board = new Board();
$game = new Game($board, $players);
