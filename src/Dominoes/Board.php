<?php

namespace Dominoes;

class Board
{

    private array $pieces;

    public function __construct()
    {
        $this->generatePieces();
    }

    public function getPieces(int $amount): array
    {
        return  array_slice($this->pieces, 0, $amount);
    }

    private function generatePieces(): void
    {
        for ($i = 0; $i < 7; $i++) {
            for ($j = 0; $j < 7; $j++) {
                $this->pieces[] = new Piece([$i, $j]);
            }
        }

        shuffle($this->pieces);
    }


}
