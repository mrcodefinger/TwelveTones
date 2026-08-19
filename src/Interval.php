<?php declare(strict_types=1);

namespace MrCodefinger\TwelveTones;

/** Interval within one octave, backed by its semitone count. */
enum Interval: int
{
    case Unison = 0;
    case MinorSecond = 1;
    case MajorSecond = 2;
    case MinorThird = 3;
    case MajorThird = 4;
    case PerfectFourth = 5;
    case Tritone = 6;
    case PerfectFifth = 7;
    case MinorSixth = 8;
    case MajorSixth = 9;
    case MinorSeventh = 10;
    case MajorSeventh = 11;

    /**
     * Complement to the octave, so an ascending interval becomes the
     * descending one that reaches the same pitch class: a minor third up
     * inverts to a major sixth down.
     */
    public function inverted(): self
    {
        return self::from((12 - $this->value) % 12);
    }
}
