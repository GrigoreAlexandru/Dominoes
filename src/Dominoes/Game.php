<?php
declare(strict_types=1);

namespace Dominoes;

use Dominoes\traits\Cli;

/**
 * Class responsible with game logic.
 */
class Game
{
    use Cli;

    /**
     * @var array
     */
    private array $players;

    /**
     * @var bool
     */
    private bool $gameEnded = false;
    /**
     * @var int
     */
    private int $playerIndex = 0;
    /**
     * @var bool
     */
    private bool $piecesDrawn = false;
    /**
     * @var array
     */
    private array $passed = [];

    /**
     * @param array $players
     */
    public function __construct(array $players)
    {
        $this->players = $players;
    }

    /**
     * @return void
     */
    public function drawPieces(): void
    {
        if ($this->piecesDrawn) {
            throw new \LogicException('Pieces already drawn');
        }

        foreach ($this->players as $player) {
            $player->drawPieces(7);
        }

        $this->piecesDrawn = true;
    }

    /**
     * @return void
     */
    public function startGame(): void
    {
        if ($this->gameEnded()) {
            throw new \LogicException('Game already ended');
        }

        if (!$this->piecesDrawn) {
            throw new \LogicException('Pieces not drawn');
        }

        $this->init();

        while (!$this->gameEnded()) {
            // check deadlock
            if (count($this->passed) === count($this->players)) {
                $this->gameEnded = true;
                $winner = $this->getLowestDotsPlayer();
                $this->say("Game ended, the winner is {$winner} with {$winner->getTotalDots()} dots!");
                break;
            }

            if ($this->currentPlayer()->hasPieces()) {
                // play turn for current player
                $this->playTurn();
                // increment or reset  player index
                $this->setNextPlayer();
            } else {
                // player has no pieces left
                $this->gameEnded = true;
                $this->say("Game ended, {$this->currentPlayer()} played all of their pieces and won!");
            }
        }

    }

    /**
     * @return bool
     */
    private function gameEnded(): bool
    {
        return $this->gameEnded || count($this->players) < 2;
    }

    /**
     * @return void
     */
    private function setFirstPlayer(): void
    {
        // set first player by finding highest double piece
        $maxDouble = -1;
        foreach ($this->players as $i => $player) {
            $highestDoublePiece = $player->getHighestDoublePiece();
            if ($highestDoublePiece && $highestDoublePiece->getDots()[0] > $maxDouble) {
                $this->playerIndex = $i;
                $maxDouble = $highestDoublePiece->getDots()[0];
            }
        }
    }

    /**
     * @return void
     */
    private function playTurn(): void
    {
        $currentPlayer = $this->currentPlayer();
            if ($currentPlayer->hasMatchingPieces()) {
                // player has matching pieces and can play
                $currentPlayer->playTurn();
                // reset pass counter
                unset($this->passed[$this->currentPlayer()->getNumber()]);
            } elseif($currentPlayer->drawPieces(1)){
                // reset to prev player, so the current player draws again
                $this->setPrevPlayer();
            } else {
                // player has no matching pieces and must pass
                $this->say("{$currentPlayer} passed!");
                if (!in_array($currentPlayer->getNumber(), $this->passed, true)) {
                    $this->passed[] = $currentPlayer->getNumber();
                }
            }
    }


    /**
     * @return void
     */
    public function setNextPlayer(): void
    {
        // increment player or reset to first player
        $this->playerIndex = $this->playerIndex >= count($this->players) - 1 ? 0 : $this->playerIndex + 1;
    }

    /**
     * @return void
     */
    public function setPrevPlayer(): void
    {
        // decrement player or reset to last player
        $this->playerIndex = $this->playerIndex === 0 ? count($this->players) - 1 : $this->playerIndex - 1;
    }

    /**
     * @return Player
     */
    private function currentPlayer(): Player
    {
        return $this->players[$this->playerIndex];
    }


    /**
     * @return void
     */
    public function init(): void
    {
        // play first turn manually
        $this->setFirstPlayer();
        $this->say('First player is: ' . $this->currentPlayer(). ' and places '. $this->currentPlayer()->getHighestDoublePiece());
        $this->currentPlayer()->playFirstTurn();
        $this->setNextPlayer();
    }

    /**
     * @return Player
     */
    private function getLowestDotsPlayer(): Player
    {
        // get player with lowest dots
        $lowestDots = 168;
        $lowestPlayer = null;
        foreach ($this->players as $player) {
            if ($player->getTotalDots() < $lowestDots) {
                $lowestDots = $player->getTotalDots();
                $lowestPlayer = $player;
            }
        }
        return $lowestPlayer;
    }

}
