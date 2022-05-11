<?php

namespace Dominoes;

class Piece
{
    private array $dots;

    /**
     * @param array $dots
     */
    public function __construct(array $dots)
    {
        $this->dots = $dots;
    }


    /**
     * @return array
     */
    public function getDots(): array
    {
        return $this->dots;
    }

    public function isDouble(): bool
    {
        return $this->dots[0] === $this->dots[1];
    }


}
