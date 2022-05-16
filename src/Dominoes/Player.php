<?php
declare(strict_types=1);

namespace Dominoes;

use Dominoes\traits\Cli;
use LogicException;

/**
 * Player class responsible for keeping and playing pieces.
 */
class Player
{
    use Cli;

    /**
     * @var bool
     */
    public static bool $SKIP_PROMPT = true;

    /**
     * @var array
     */
    private array $pieces = [];
    /**
     * @var int
     */
    private int $number;
    /**
     * @var Board
     */
    private Board $board;

    /**
     * @param int $number
     * @param Board $board
     */
    public function __construct(int $number, Board $board)
    {
        $this->number = $number;
        $this->board = $board;
    }


    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }


    /**
     * @return bool
     */
    public function hasPieces(): bool
    {
        return !empty($this->pieces);
    }


    /**
     * @param $amount
     * @return bool
     */
    public function drawPieces($amount): bool
    {
        $drawnPieces = $this->board->drawPieces($amount);
        if ($drawnPieces) {
            $this->say("$this drew {$amount} pieces: " . implode(', ', $drawnPieces));
            $this->pieces = array_merge($this->pieces, $drawnPieces);
            return true;
        }
        return false;
    }

    /**
     * @return Piece|null
     */
    public function getHighestDoublePiece(): ?Piece
    {
        $highestDouble = null;
        foreach ($this->pieces as $piece) {
            if ($piece->isDouble() && ($highestDouble === null || $piece->getDots()[0] > $highestDouble->getDots()[0])) {
                $highestDouble = $piece;
            }
        }
        return $highestDouble;
    }


    /**
     * @return array
     */
    public function getAvailablePieces(): array
    {
        $availablePieces = [];

        foreach ($this->pieces as $piece) {
            if ($piece->matches($this->board->getOpenEnds())) {
                $availablePieces[] = $piece;
            }
        }

        return $availablePieces;
    }

    /**
     * @throws LogicException
     */
    public function playTurn(): void
    {
        $availablePieces = $this->getAvailablePieces();
        $this->printHand($this->number, $this->pieces);
        $piece = $this->choosePiece($this->number, $availablePieces);
        $this->placePiece($piece);
    }

    /**
     * @param Piece $piece
     * @return void
     */
    public function removePiece(Piece $piece): void
    {
        $this->pieces = array_filter($this->pieces, static function (Piece $p) use ($piece) {
            return $p !== $piece;
        });
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'Player#' . $this->number;
    }

    /**
     * @return void
     */
    public function playFirstTurn(): void
    {
        $this->placePiece($this->getHighestDoublePiece());
    }

    /**
     * @param Piece $piece
     * @return void
     */
    private function placePiece(Piece $piece): void
    {
        $this->board->placePiece($piece);
        $this->removePiece($piece);
    }

    /**
     * @return bool
     */
    public function hasMatchingPieces(): bool
    {
        return count($this->getAvailablePieces()) > 0;
    }

    /**
     * @return int
     */
    public function getTotalDots(): int
    {
        $total = 0;
        foreach ($this->pieces as $piece) {
            $total += $piece->getDots()[0] + $piece->getDots()[1];
        }
        return $total;
    }

}
