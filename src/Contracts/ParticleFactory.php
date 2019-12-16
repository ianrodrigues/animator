<?php

declare(strict_types=1);

namespace Rodrigues\Animator\Contracts;

interface ParticleFactory
{
    public function createParticles(string $chamber): array;
}
