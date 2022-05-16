<?php
declare(strict_types=1);

namespace Dominoes;

use Dominoes\traits\Cli;

/**
 * Class responsible with pieces on the board.
 */
class Board
{
    use Cli;

    /**
     * @var array
     */
    private array $pieces;
    /**
     * @var array
     */
    private array $openEnds = [];

    /**
     *
     */
    public function __construct()
    {
        $this->generatePieces();
    }

    /**
     * @return array
     */
    public function getOpenEnds(): array
    {
        return $this->openEnds;
    }


    /**
     * @param int $amount
     * @return array|null
     */
    public function drawPieces(int $amount): ?array
    {
        if ($amount > count($this->pieces)) {
            return null;
        }

        return  array_splice($this->pieces, 0, $amount);
    }

    /**
     * @param Piece $piece
     * @return void
     */
    public function placePiece(Piece $piece): void
    {
        if (!$this->openEnds || $this->openEnds[0] === $this->openEnds[1]) {
            // open ends have the same value, use the given piece to fill the ends values.
            $this->openEnds = $piece->getDots();
        } elseif (!$piece->isDouble() && count(array_intersect($piece->getDots(), $this->openEnds)) === 2) {
            // both the ends and the piece have matching dots, use the value of the first dot from current end for both ends.
            $this->openEnds = [$this->openEnds[0], $this->openEnds[0]];
        } elseif (!$piece->isDouble()) {
            // only one matching end, use the left ends values.
            $this->openEnds = array_merge(array_diff($this->openEnds, $piece->getDots()), array_diff($piece->getDots(), $this->openEnds));
        }

        $this->say('New open ends: ' . implode(', ', $this->openEnds));
    }

    /**
     * @return void
     */
    private function generatePieces(): void
    {
        // generate 28 pieces
        for ($i = 6; $i >= 0; $i--) {
            for ($j = $i; $j >= 0; $j--) {
                $this->pieces[] = new Piece([$i, $j]);
            }
        }

        // randomize pieces
        shuffle($this->pieces);
    }


}
