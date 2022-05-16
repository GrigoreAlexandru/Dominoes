<?php

namespace Tests\Dominoes;

use Dominoes\Board;
use Dominoes\Piece;
use PHPUnit\Framework\TestCase;

class BoardTest extends TestCase
{
    private Board $board;

    public function setUp(): void
    {
        $this->board = new Board();
    }

    public function testPlacePiece(): void
    {
        $this->board->placePiece(new Piece([5,5]));
        $this->board->placePiece(new Piece([5,1]));
        $this->assertEquals([5,1], $this->board->getOpenEnds());
    }

    public function testPlacePiece2(): void
    {
        $this->board->placePiece(new Piece([5,1]));
        $this->board->placePiece(new Piece([1,5]));
        $this->assertEquals([5,5], $this->board->getOpenEnds());
    }

    public function testPlacePiece3(): void
    {
        $this->board->placePiece(new Piece([5,1]));
        $this->board->placePiece(new Piece([2,5]));
        $this->assertEquals([1,2], $this->board->getOpenEnds());
    }

    public function testPlacePiece4(): void
    {
        $this->board->placePiece(new Piece([5,1]));
        $this->board->placePiece(new Piece([5,5]));
        $this->assertEquals([5,1], $this->board->getOpenEnds());
    }

    public function testPlacePiece5(): void
    {
        $this->board->placePiece(new Piece([5,1]));
        $this->board->placePiece(new Piece([2,5]));
        $this->board->placePiece(new Piece([2,3]));
        $this->assertEquals([1,3], $this->board->getOpenEnds());
    }
}
