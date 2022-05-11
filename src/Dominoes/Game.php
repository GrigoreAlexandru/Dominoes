<?php

declare(strict_types=1);

namespace Dominoes;

class Game
{
//    private int $playersNr;
    private array $players;
    private Board $board;

    /**
     * @param Board $board
     * @param array $players
     */
    public function __construct(Board $board, array $players)
    {
        $this->players = $players;
        $this->board = $board;
    }

//    public function __construct(int $playersNr)
//    {
//        $this->playersNr = $playersNr;
//    }

    public function start(): void
    {
        foreach ($this->players as $player) {
            $pieces = $this->board->getPieces(7);
            $player->setPieces($pieces);
        }
    }

}
