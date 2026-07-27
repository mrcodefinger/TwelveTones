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
}
