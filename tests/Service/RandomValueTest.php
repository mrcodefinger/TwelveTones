<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use MrCodefinger\TwelveTones\Service\RandomValue;

final class RandomValueTest extends TestCase
{
    public function testGetRandomValue()
    {
        $array = ['A', 'B', 'C'];
        $this->assertTrue(in_array(new RandomValue($array), $array));
    }
}