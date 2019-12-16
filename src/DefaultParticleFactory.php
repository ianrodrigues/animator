<?php

declare(strict_types=1);

namespace Rodrigues\Animator;

use Rodrigues\Animator\Particle;
use Rodrigues\Animator\Contracts\ParticleFactory;
use Rodrigues\Animator\Exception\InvalidDirectionException;

final class DefaultParticleFactory implements ParticleFactory
{
    public function createParticles(string $chamber): array
    {
        $particles = [];
        $chamberSize = strlen($chamber);

        for ($i = 0; $i < $chamberSize; $i++) {
            if ($chamber[$i] === Animator::EMPTY_LOCATION_TOKEN) {
                continue;
            }

            $particles[] = new Particle($i, $chamber[$i]);
        }

        return $particles;
    }
}
