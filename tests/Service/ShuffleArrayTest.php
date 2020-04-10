<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use MrCodefinger\TwelveTones\Service\ShuffleArray;

final class ShuffleArrayTest extends TestCase
{
    public function testSortRandom()
    {
        $array = ['A', 'B', 'C', 'D', 'E'];
        $shuffleArray = new ShuffleArray($array);
        $this->assertTrue(is_array($shuffleArray->getValue()));
    }
}