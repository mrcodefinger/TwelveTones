<?php declare(strict_types=1);

namespace MrCodefinger\TwelveTones\Tests\Service;

use MrCodefinger\TwelveTones\Service\ShuffleArray;
use PHPUnit\Framework\TestCase;

final class ShuffleArrayTest extends TestCase
{
    public function testSortRandom(): void
    {
        $array = ['A', 'B', 'C', 'D', 'E'];
        $shuffleArray = new ShuffleArray($array);
        $this->assertIsArray($shuffleArray->getValue());
    }
}
