<?php

declare(strict_types=1);

namespace Dominoes\traits;

use Dominoes\Piece;
use Dominoes\Player;
use LogicException;

trait Cli
{

    /**
     * @throws LogicException
     */
    public function choosePiece(int $playerNr, array $pieces): Piece {
        $piecesCount = count($pieces);

        if ($piecesCount === 0) {
            throw new LogicException("No pieces to choose from.");
        }

        if(Player::$SKIP_PROMPT) {
            return $pieces[0];
        }

        $index = null;
        while ($index === null || (1 > $index) || ($index > $piecesCount+1)){
            echo "Please choose a piece for player $playerNr: \n";

            foreach ($pieces as $i => $piece) {
                echo ($i+1).": " . $piece . "\n";
            }

            $index = (int) trim(fgets(STDIN));
        }
        return $pieces[$index-1];
    }

    public function printHand(int $playerNr,array $pieces): void {
        echo "Player $playerNr 's hand: \n";
        echo implode(', ', $pieces) . "\n";
    }

    public function say(string $message): void {
        echo $message . "\n";
    }
}
