<?php declare(strict_types=1);

namespace MrCodefinger\TwelveTones\Tests\Service;

use MrCodefinger\TwelveTones\Direction;
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

    public function testChromaticOrderFromCUsesSharps(): void
    {
        $tones = new TwelveTones($this->createToneList(), OrderMode::Chromatic);

        $this->assertSame(
            ['C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#', 'A', 'A#', 'B'],
            $tones->getValue(),
        );
    }

    public function testWholeToneOrderFromCConcatenatesBothScales(): void
    {
        $tones = new TwelveTones($this->createToneList(), OrderMode::WholeTone);

        $this->assertSame(
            ['C', 'D', 'E', 'F#', 'G#', 'A#', 'C#', 'D#', 'F', 'G', 'A', 'B'],
            $tones->getValue(),
        );
    }

    public function testMinorThirdOrderFromCUsesSharps(): void
    {
        $tones = new TwelveTones($this->createToneList(), OrderMode::MinorThird);

        $this->assertSame(
            ['C', 'D#', 'F#', 'A', 'C#', 'E', 'G', 'A#', 'D', 'F', 'G#', 'B'],
            $tones->getValue(),
        );
    }

    public function testMajorThirdOrderFromCUsesSharps(): void
    {
        $tones = new TwelveTones($this->createToneList(), OrderMode::MajorThird);

        $this->assertSame(
            ['C', 'E', 'G#', 'C#', 'F', 'A', 'D', 'F#', 'A#', 'D#', 'G', 'B'],
            $tones->getValue(),
        );
    }

    public function testChromaticOrderRotatesFromSharpStart(): void
    {
        $tones = new TwelveTones($this->createToneList(), OrderMode::Chromatic, start: 'F#');

        $this->assertSame(
            ['F#', 'G', 'G#', 'A', 'A#', 'B', 'C', 'C#', 'D', 'D#', 'E', 'F'],
            $tones->getValue(),
        );
    }

    public function testFifthsOrderRotatesFromStart(): void
    {
        $tones = new TwelveTones($this->createToneList(), OrderMode::Fifths, start: 'G');

        $this->assertSame(
            ['G', 'D', 'A', 'E', 'B', 'F#', 'C#', 'G#', 'D#', 'A#', 'F', 'C'],
            $tones->getValue(),
        );
    }

    public function testFlatStartForcesFlatSpellings(): void
    {
        $tones = new TwelveTones($this->createToneList(), OrderMode::Chromatic, start: 'Eb');

        $this->assertSame(
            ['Eb', 'E', 'F', 'Gb', 'G', 'Ab', 'A', 'Bb', 'B', 'C', 'Db', 'D'],
            $tones->getValue(),
        );
    }

    public function testChromaticDescendingFromCUsesFlats(): void
    {
        $tones = new TwelveTones($this->createToneList(), OrderMode::Chromatic, direction: Direction::Descending);

        $this->assertSame(
            ['C', 'B', 'Bb', 'A', 'Ab', 'G', 'Gb', 'F', 'E', 'Eb', 'D', 'Db'],
            $tones->getValue(),
        );
    }

    public function testWholeToneDescendingFromCUsesFlats(): void
    {
        $tones = new TwelveTones($this->createToneList(), OrderMode::WholeTone, direction: Direction::Descending);

        $this->assertSame(
            ['C', 'Bb', 'Ab', 'Gb', 'E', 'D', 'Db', 'B', 'A', 'G', 'F', 'Eb'],
            $tones->getValue(),
        );
    }

    public function testMinorThirdDescendingFromCUsesFlats(): void
    {
        $tones = new TwelveTones($this->createToneList(), OrderMode::MinorThird, direction: Direction::Descending);

        $this->assertSame(
            ['C', 'A', 'Gb', 'Eb', 'Db', 'Bb', 'G', 'E', 'D', 'B', 'Ab', 'F'],
            $tones->getValue(),
        );
    }

    public function testMajorThirdDescendingFromCUsesFlats(): void
    {
        $tones = new TwelveTones($this->createToneList(), OrderMode::MajorThird, direction: Direction::Descending);

        $this->assertSame(
            ['C', 'Ab', 'E', 'Db', 'A', 'F', 'D', 'Bb', 'Gb', 'Eb', 'B', 'G'],
            $tones->getValue(),
        );
    }

    public function testRandomOrderIgnoresDescendingDirection(): void
    {
        $tones = new TwelveTones($this->createToneList(), OrderMode::Random, direction: Direction::Descending);
        $value = $tones->getValue();

        $this->assertCount(12, $value);
        $this->assertCount(12, array_unique($value));
    }
}
