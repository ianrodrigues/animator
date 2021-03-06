<?php

declare(strict_types=1);

namespace Rodrigues\Animator;

use Rodrigues\Animator\Contracts\ParticleFactory;
use Rodrigues\Animator\Exception\InvalidSpeedException;
use Rodrigues\Animator\Exception\InvalidChamberSizeException;

final class Animation
{
    public const OCCUPIED_LOCATION_TOKEN = 'X';
    public const EMPTY_LOCATION_TOKEN = '.';

    private $particleFactory;

    public function __construct(ParticleFactory $particleFactory)
    {
        $this->particleFactory = $particleFactory;
    }

    public function animate(int $speed, string $chamber): array
    {
        $chamberSize = strlen($chamber);
        $this->assertValidation($speed, $chamberSize);

        $particles = $this->particleFactory->createParticles($chamber);

        $chamberOverTime = [];
        $time = 0;

        do {
            $rate = $time * $speed;
            $newState = $this->chamberStateFor($chamberSize, $particles, $rate);
            $chamberOverTime[] = $newState;

            $time++;
        } while (trim($newState, Animation::EMPTY_LOCATION_TOKEN));
        
        return $chamberOverTime;
    }

    private function assertValidation(int $speed, int $chamberSize): void
    {
        if ($speed < 1 || $speed > 10) {
            throw new InvalidSpeedException('Speed should be between 1 and 10.');
        }

        if ($chamberSize < 1 || $chamberSize > 50) {
            throw new InvalidChamberSizeException('Chamber size should be between 1 and 50.');
        }
    }

    private function chamberStateFor($chamberSize, array $particles, int $rate): string
    {
        $state = str_repeat(Animation::EMPTY_LOCATION_TOKEN, $chamberSize);
        
        foreach ($particles as $particle) {
            $position = $particle->getPositionFor($rate);
            
            if ($position >= 0 && $position < $chamberSize) {
                $state[$position] = Animation::OCCUPIED_LOCATION_TOKEN;
            }
        }

        return $state;
    }
}
