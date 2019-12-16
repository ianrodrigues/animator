<?php

declare(strict_types=1);

namespace Rodrigues\Animator\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Rodrigues\Animator\Particle;
use Rodrigues\Animator\Exception\InvalidDirectionException;

class ParticleTest extends TestCase
{
    public function test_validate_direction(): void
    {
        $this->expectException(InvalidDirectionException::class);
        $this->expectExceptionMessage('Direction should be either "L" or "R".');

        $particle = new Particle(0, 'invalid direction');
    }

    /**
     * @dataProvider particlePositions
     */
    public function test_return_next_position(int $initialPosition, string $direction, int $speed, int $time, int $position): void
    {
        $particle = new Particle($initialPosition, $direction);

        $this->assertEquals($position, $particle->getPositionFor($speed * $time));
    }

    public function particlePositions(): iterable
    {
        yield [0, 'R', 1, 1, 1];
        yield [1, 'R', 2, 1, 3];
        yield [0, 'R', 3, 1, 3];
        yield [0, 'L', 1, 1, -1];
        yield [1, 'L', 2, 1, -1];
        yield [0, 'L', 3, 1, -3];
    }
}
