<?php

namespace Dominoes;

class Player
{
    private array $pieces;

    /**
     * @param array $pieces
     */
    public function addPieces(array $pieces): void
    {
        $this->pieces = $pieces;
    }

    public function getHighestDouble(): ?Piece
    {
        $highestDouble = null;
        foreach ($this->pieces as $piece) {
            if ($piece->isDouble()) {
                return $piece;
            }
        }
        return $highestDouble;
    }


}
