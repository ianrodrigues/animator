<?php

declare(strict_types=1);

namespace Rodrigues\Animator\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Rodrigues\Animator\Animator;

class AnimatorTest extends TestCase
{
    /**
     * @dataProvider expectedChamber
     */
    public function test_animate(int $speed, string $chamber, array $expected): void
    {
        $animator = new Animator();

        $this->assertEquals($expected, $animator->animate($speed, $chamber));
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
