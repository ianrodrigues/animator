<?php

declare(strict_types=1);

namespace Rodrigues\Animator\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Rodrigues\Animator\Particle;
use Rodrigues\Animator\DefaultParticleFactory;

class DefaultParticleFactoryTest extends TestCase
{
    public function test_create_particles_from_chamber(): void
    {
        $factory = new DefaultParticleFactory();

        $particles = $factory->createParticles('RL..RL');

        $this->assertEquals([
            new Particle(0, 'R'),
            new Particle(1, 'L'),
            new Particle(4, 'R'),
            new Particle(5, 'L'),
        ], $particles);
    }
}
