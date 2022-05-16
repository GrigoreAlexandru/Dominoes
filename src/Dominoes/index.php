<?php

declare(strict_types=1);

namespace Dominoes;

require __DIR__ . '/../../vendor/autoload.php';


// set cli options
$options = getopt("p:a::");
// use -p x, where x is the number of players
$playersNr =  $options['p'] ?? 2;
// use -a to skip prompting for player input and always choose the first piece
Player::$SKIP_PROMPT = array_key_exists('a', $options);

$board = new Board();

$players = [];

// generate players
for ($i = 0; $i < $playersNr; $i++) {
            $players[] = new Player($i+1, $board);
}

$game = new Game($players);
$game->drawPieces();
$game->startGame();
