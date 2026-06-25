<?php declare(strict_types=1);

namespace MrCodefinger\TwelveTones\Tests\Service;

use MrCodefinger\TwelveTones\Service\RandomValue;
use PHPUnit\Framework\TestCase;

final class RandomValueTest extends TestCase
{
    public function testGetRandomValue(): void
    {
        $array = ['A', 'B', 'C'];
        $this->assertContains((string) new RandomValue($array), $array);
    }
}
