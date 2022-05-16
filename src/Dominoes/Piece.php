<?php
declare(strict_types=1);

namespace Dominoes;

/**
 *
 */
class Piece
{
    /**
     * @var array
     */
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

    /**
     * @return bool
     */
    public function isDouble(): bool
    {
        return $this->dots[0] === $this->dots[1];
    }

    /**
     * @param array $openEnds
     * @return bool
     */
    public function matches(array $openEnds): bool
    {
        return $this->dots[0] === $openEnds[0]
            || $this->dots[0] === $openEnds[1]
            || $this->dots[1] === $openEnds[0]
            || $this->dots[1] === $openEnds[1];
    }

    /**
     * @return string
     */
    public function __toString() {
        return '['.implode('|', $this->dots).']';
    }
}
