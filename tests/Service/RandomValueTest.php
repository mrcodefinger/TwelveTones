<?php declare(strict_types=1);

namespace MrCodefinger\TwelveTones\Tests\Service;

use MrCodefinger\TwelveTones\OrderMode;
use MrCodefinger\TwelveTones\Service\RandomValue;
use PHPUnit\Framework\TestCase;

final class RandomValueTest extends TestCase
{
    public function testGetRandomValue(): void
    {
        $array = ['A', 'B', 'C'];
        $this->assertContains((string) new RandomValue($array), $array);
    }

    public function testFormatUsesCanonicalSpellingsForCircleOrders(): void
    {
        $tone = new RandomValue(['Ab', 'G#']);

        $this->assertSame('G#', $tone->format(OrderMode::Fifths));
        $this->assertSame('Ab', $tone->format(OrderMode::Fourths));
    }

    public function testFormatUsesModeDefaultSpellingsForIntervalOrders(): void
    {
        $tone = new RandomValue(['Ab', 'G#']);

        $this->assertSame('G#', $tone->format(OrderMode::Chromatic));
        $this->assertSame('G#', $tone->format(OrderMode::WholeTone));
        $this->assertSame('Ab', $tone->format(OrderMode::MinorThird));
        $this->assertSame('G#', $tone->format(OrderMode::MajorThird));
    }

    public function testFormatHonorsExplicitUseFlatsOverride(): void
    {
        $tone = new RandomValue(['Ab', 'G#']);

        $this->assertSame('Ab', $tone->format(OrderMode::Chromatic, useFlats: true));
        $this->assertSame('G#', $tone->format(OrderMode::MinorThird, useFlats: false));
    }
}
