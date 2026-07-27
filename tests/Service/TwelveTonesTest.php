<?php declare(strict_types=1);

namespace MrCodefinger\TwelveTones\Tests\Service;

use MrCodefinger\TwelveTones\OrderMode;
use MrCodefinger\TwelveTones\Service\RandomValue;
use MrCodefinger\TwelveTones\Service\TwelveTones;
use PHPUnit\Framework\TestCase;

final class TwelveTonesTest extends TestCase
{
    /** @return list<string|RandomValue> */
    private function createToneList(): array
    {
        return [
            'A',
            'B',
            'C',
            'D',
            'E',
            'F',
            'G',
            new RandomValue(['Ab', 'G#']),
            new RandomValue(['Bb', 'A#']),
            new RandomValue(['C#', 'Db']),
            new RandomValue(['D#', 'Eb']),
            new RandomValue(['F#', 'Gb']),
        ];
    }

    public function testFifthsOrderUsesCircleOfFifthsWithSharps(): void
    {
        $tones = new TwelveTones($this->createToneList(), OrderMode::Fifths);

        $this->assertSame(
            ['C', 'G', 'D', 'A', 'E', 'B', 'F#', 'C#', 'G#', 'D#', 'A#', 'F'],
            $tones->getValue(),
        );
    }

    public function testFourthsOrderUsesCircleOfFourthsWithFlats(): void
    {
        $tones = new TwelveTones($this->createToneList(), OrderMode::Fourths);

        $this->assertSame(
            ['C', 'F', 'Bb', 'Eb', 'Ab', 'Db', 'Gb', 'B', 'E', 'A', 'D', 'G'],
            $tones->getValue(),
        );
    }

    public function testRandomOrderContainsAllTonesAndCanVary(): void
    {
        $tones = new TwelveTones($this->createToneList(), OrderMode::Random);
        $orders = [];

        for ($attempt = 0; $attempt < 20; ++$attempt) {
            $value = $tones->getValue();
            $this->assertCount(12, $value);
            $this->assertCount(12, array_unique($value));
            $orders[] = implode(' ', $value);
        }

        $this->assertGreaterThan(1, count(array_unique($orders)));
    }
}
