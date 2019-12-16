<?php

declare(strict_types=1);

namespace Rodrigues\Animator\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Rodrigues\Animator\Animator;
use Rodrigues\Animator\DefaultParticleFactory;
use Rodrigues\Animator\Exception\InvalidSpeedException;
use Rodrigues\Animator\Exception\InvalidChamberSizeException;

class AnimatorTest extends TestCase
{
    protected function setUp(): void
    {
        $this->animator = new Animator(new DefaultParticleFactory());

        parent::setUp();
    }

    /**
     * @dataProvider invalidSpeeds
     */
    public function test_validate_speed(int $speed): void
    {
        $this->expectException(InvalidSpeedException::class);
        $this->expectExceptionMessage('Speed should be between 1 and 10.');

        $this->animator->animate($speed, 'RLRLRLRL');
    }

    /**
     * @dataProvider invalidChambers
     */
    public function test_validate_chamber_size(string $chamber): void
    {
        $this->expectException(InvalidChamberSizeException::class);
        $this->expectExceptionMessage('Chamber size should be between 1 and 50.');

        $this->animator->animate(1, $chamber);
    }

    /**
     * @dataProvider expectedChamber
     */
    public function test_animate(int $speed, string $chamber, array $expected): void
    {
        $this->assertEquals($expected, $this->animator->animate($speed, $chamber));
    }

    public function invalidSpeeds(): iterable
    {
        yield [0];
        yield [11];
    }

    public function invalidChambers(): iterable
    {
        yield [''];
        yield ['RLRLRLRLRLRLRLRLRLRLRLRLRLRLRLRLRLRLRLRLRLRLRLRLRLRLRLRLRLRLRL'];
    }

    public function expectedChamber(): iterable
    {
        yield [2, '..R....', [
            '..X....',
            '....X..',
            '......X',
            '.......',
        ]];

        yield [3, 'RR..LRL', [
            'XX..XXX',
            '.X.XX..',
            'X.....X',
            '.......'
        ]];

        yield [2, 'LRLR.LRLR', [
            'XXXX.XXXX',
            'X..X.X..X',
            '.X.X.X.X.',
            '.X.....X.',
            '.........'
        ]];

        yield [10, 'RLRLRLRLRL', [
            'XXXXXXXXXX',
            '..........'
        ]];

        yield [1, '...', [
            '...'
        ]];

        yield [1, 'LRRL.LR.LRR.R.LRRL.', [
            'XXXX.XX.XXX.X.XXXX.',
            '..XXX..X..XX.X..XX.',
            '.X.XX.X.X..XX.XX.XX',
            'X.X.XX...X.XXXXX..X',
            '.X..XXX...X..XX.X..',
            'X..X..XX.X.XX.XX.X.',
            '..X....XX..XX..XX.X',
            '.X.....XXXX..X..XX.',
            'X.....X..XX...X..XX',
            '.....X..X.XX...X..X',
            '....X..X...XX...X..',
            '...X..X.....XX...X.',
            '..X..X.......XX...X',
            '.X..X.........XX...',
            'X..X...........XX..',
            '..X.............XX.',
            '.X...............XX',
            'X.................X',
            '...................'
        ]];
    }
}
