<?php declare(strict_types=1);

namespace MrCodefinger\TwelveTones;

enum OrderMode: string
{
    case Random = 'random';
    case Fifths = 'fifths';
    case Fourths = 'fourths';
    case Chromatic = 'chromatic';
    case WholeTone = 'wholeTone';
    case MinorThird = 'minorThird';
    case MajorThird = 'majorThird';

    public function step(): ?int
    {
        return match ($this) {
            self::Random => null,
            self::Chromatic => 1,
            self::WholeTone => 2,
            self::MinorThird => 3,
            self::MajorThird => 4,
            self::Fourths => 5,
            self::Fifths => 7,
        };
    }

    public function prefersFlats(): bool
    {
        return match ($this) {
            self::Fourths, self::MinorThird => true,
            default => false,
        };
    }
}
