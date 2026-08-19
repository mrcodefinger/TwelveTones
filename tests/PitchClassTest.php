<?php declare(strict_types=1);

namespace MrCodefinger\TwelveTones\Tests;

use MrCodefinger\TwelveTones\PitchClass;
use PHPUnit\Framework\TestCase;

final class PitchClassTest extends TestCase
{
    public function testFromStringMapsEnharmonicNotesToSamePitchClass(): void
    {
        $this->assertSame(8, PitchClass::fromString('G#'));
        $this->assertSame(8, PitchClass::fromString('Ab'));
        $this->assertSame(1, PitchClass::fromString('C#'));
        $this->assertSame(1, PitchClass::fromString('Db'));
    }

    public function testToStringUsesCanonicalSpellings(): void
    {
        $this->assertSame('G#', PitchClass::toString(8, useFlats: false));
        $this->assertSame('Ab', PitchClass::toString(8, useFlats: true));
        $this->assertSame('C#', PitchClass::toString(1, useFlats: false));
        $this->assertSame('Db', PitchClass::toString(1, useFlats: true));
    }

    public function testCircleConstantsContainAllTwelvePitchClasses(): void
    {
        $this->assertCount(12, PitchClass::CIRCLE_OF_FIFTHS);
        $this->assertCount(12, PitchClass::CIRCLE_OF_FOURTHS);
        foreach ([PitchClass::CIRCLE_OF_FIFTHS, PitchClass::CIRCLE_OF_FOURTHS] as $circle) {
            $pitchClasses = array_values(array_unique($circle));
            sort($pitchClasses);
            $this->assertSame(range(0, 11), $pitchClasses);
        }
    }

    public function testIntervalCycleFromCMatchesCircleConstants(): void
    {
        $this->assertSame(PitchClass::CIRCLE_OF_FIFTHS, PitchClass::intervalCycle(0, 7));
        $this->assertSame(PitchClass::CIRCLE_OF_FOURTHS, PitchClass::intervalCycle(0, 5));
    }

    public function testIntervalCycleConcatenatesRemainingCycles(): void
    {
        $this->assertSame(
            [0, 2, 4, 6, 8, 10, 1, 3, 5, 7, 9, 11],
            PitchClass::intervalCycle(0, 2),
        );
        $this->assertSame(
            [0, 3, 6, 9, 1, 4, 7, 10, 2, 5, 8, 11],
            PitchClass::intervalCycle(0, 3),
        );
        $this->assertSame(
            [0, 4, 8, 1, 5, 9, 2, 6, 10, 3, 7, 11],
            PitchClass::intervalCycle(0, 4),
        );
    }

    public function testIntervalCycleRotatesFromStart(): void
    {
        $this->assertSame(
            [6, 7, 8, 9, 10, 11, 0, 1, 2, 3, 4, 5],
            PitchClass::intervalCycle(6, 1),
        );
        $this->assertSame(
            [7, 2, 9, 4, 11, 6, 1, 8, 3, 10, 5, 0],
            PitchClass::intervalCycle(7, 7),
        );
    }

    public function testTransposeWrapsAroundTheOctave(): void
    {
        $this->assertSame(2, PitchClass::transpose(0, 2));
        $this->assertSame(1, PitchClass::transpose(11, 2));
        $this->assertSame(9, PitchClass::transpose(0, -3));
        $this->assertSame(0, PitchClass::transpose(0, 12));
    }

    public function testTransposeNameKeepsTheAccidentalStyleOfTheSourceNote(): void
    {
        $this->assertSame('Eb', PitchClass::transposeName('Db', 2));
        $this->assertSame('D#', PitchClass::transposeName('C#', 2));
        $this->assertSame('C#', PitchClass::transposeName('B', 2));
    }

    public function testTransposeNameHonoursExplicitSpelling(): void
    {
        $this->assertSame('D#', PitchClass::transposeName('Db', 2, useFlats: false));
        $this->assertSame('Eb', PitchClass::transposeName('C#', 2, useFlats: true));
    }

    public function testTransposeSequenceSpellsNaturalsLikeTheSequence(): void
    {
        $this->assertSame(
            ['D', 'Eb', 'F', 'Gb'],
            PitchClass::transposeSequence(['C', 'Db', 'Eb', 'E'], 2),
        );
        $this->assertSame(
            ['D', 'D#', 'F', 'F#'],
            PitchClass::transposeSequence(['C', 'C#', 'D#', 'E'], 2),
        );
    }

    public function testTransposeSequenceKeepsMixedSpellingsPerNote(): void
    {
        $this->assertSame(
            ['Eb', 'D#', 'D'],
            PitchClass::transposeSequence(['Db', 'C#', 'C'], 2),
        );
    }

    public function testTransposeSequenceHonoursExplicitSpelling(): void
    {
        $this->assertSame(
            ['Eb', 'Eb', 'D'],
            PitchClass::transposeSequence(['Db', 'C#', 'C'], 2, useFlats: true),
        );
    }

    public function testTransposeSequenceTreatsInvertedIntervalsAsEqual(): void
    {
        $row = ['C', 'D', 'E', 'F#', 'G#', 'A#'];

        $this->assertSame(
            PitchClass::transposeSequence($row, 9),
            PitchClass::transposeSequence($row, -3),
        );
    }

    public function testIntervalCycleAcceptsNegativeSteps(): void
    {
        $this->assertSame(
            [0, 11, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1],
            PitchClass::intervalCycle(0, -1),
        );
        $this->assertSame(
            [0, 10, 8, 6, 4, 2, 1, 11, 9, 7, 5, 3],
            PitchClass::intervalCycle(0, -2),
        );
        $this->assertSame(
            [0, 9, 6, 3, 1, 10, 7, 4, 2, 11, 8, 5],
            PitchClass::intervalCycle(0, -3),
        );
        $this->assertSame(
            [0, 8, 4, 1, 9, 5, 2, 10, 6, 3, 11, 7],
            PitchClass::intervalCycle(0, -4),
        );
    }
}
