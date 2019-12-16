<?php

declare(strict_types=1);

namespace Rodrigues\Animator;

use Rodrigues\Animator\Exception\InvalidSpeedException;
use Rodrigues\Animator\Exception\InvalidChamberSizeException;

final class Animator
{
    private const OCCUPIED_LOCATION_TOKEN = 'X';
    private const EMPTY_LOCATION_TOKEN = '.';

    public function animate(int $speed, string $chamber): array
    {
        if ($speed < 1 || $speed > 10) {
            throw new InvalidSpeedException('Speed should be between 1 and 10.');
        }

        $chamberSize = strlen($chamber);
        if ($chamberSize < 1 || $chamberSize > 50) {
            throw new InvalidChamberSizeException('Chamber size should be between 1 and 50.');
        }

        $particles = [];

        for ($i = 0; $i < $chamberSize; $i++) {
            if ($chamber[$i] === self::EMPTY_LOCATION_TOKEN) {
                continue;
            }

            $particles[] = new Particle($i, $chamber[$i]);
        }

        $chamberOverTime = [];

        $time = 0;
        do {
            $rate = $time * $speed;
            $chamber = $this->updateChamberState($chamber, $particles, $rate);
            $chamberOverTime[] = $chamber;

            $time++;
        } while (trim($chamber, self::EMPTY_LOCATION_TOKEN));
        
        return $chamberOverTime;
    }

    private function updateChamberState(string $chamber, array $particles, int $rate): string
    {
        $chamberSize = strlen($chamber);
        $state = str_repeat(self::EMPTY_LOCATION_TOKEN, $chamberSize);
        
        foreach ($particles as $particle) {
            $position = $particle->getNextPosition($rate);
            
            if ($position >= 0 && $position < $chamberSize) {
                $state[$position] = self::OCCUPIED_LOCATION_TOKEN;
            }
        }

        return $state;
    }
}
