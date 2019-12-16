<?php

declare(strict_types=1);

namespace Rodrigues\Animator;

use Rodrigues\Animator\Exception\InvalidDirectionException;

final class Particle
{
    private const LEFT_TOKEN = 'L';
    private const RIGHT_TOKEN = 'R';

    private $initialPosition;
    private $direction;

    public function __construct(int $initialPosition, string $direction)
    {
        if (! in_array($direction, [self::LEFT_TOKEN, self::RIGHT_TOKEN])) {
            throw new InvalidDirectionException('Direction should be either "L" or "R".');
        }

        $this->initialPosition = $initialPosition;
        $this->direction = $direction;
    }

    public function getPositionFor(int $rate): int
    {
        if ($this->direction === self::RIGHT_TOKEN) {
            return $this->initialPosition + $rate;
        }

        return $this->initialPosition - $rate;
    }
}
