<?php declare(strict_types=1);

namespace MrCodefinger\TwelveTones\Tests;

use MrCodefinger\TwelveTones\Interval;
use PHPUnit\Framework\TestCase;

final class IntervalTest extends TestCase
{
    public function testCasesCoverEverySemitoneWithinTheOctave(): void
    {
        $semitones = array_map(
            static fn (Interval $interval): int => $interval->value,
            Interval::cases(),
        );

        $this->assertSame(range(0, 11), $semitones);
    }

    public function testInstrumentTranspositionsMapToIntervals(): void
    {
        $this->assertSame(2, Interval::MajorSecond->value);
        $this->assertSame(9, Interval::MajorSixth->value);
        $this->assertSame(7, Interval::PerfectFifth->value);
    }

    public function testInvertedReturnsTheComplementToTheOctave(): void
    {
        $this->assertSame(Interval::MajorSixth, Interval::MinorThird->inverted());
        $this->assertSame(Interval::MinorThird, Interval::MajorSixth->inverted());
        $this->assertSame(Interval::MinorSeventh, Interval::MajorSecond->inverted());
        $this->assertSame(Interval::PerfectFourth, Interval::PerfectFifth->inverted());
        $this->assertSame(Interval::Tritone, Interval::Tritone->inverted());
        $this->assertSame(Interval::Unison, Interval::Unison->inverted());
    }

    public function testTryFromRejectsSemitonesOutsideTheOctave(): void
    {
        $this->assertNull(Interval::tryFrom(12));
        $this->assertNull(Interval::tryFrom(-1));
        $this->assertSame(Interval::MajorSecond, Interval::tryFrom(2));
    }
}
