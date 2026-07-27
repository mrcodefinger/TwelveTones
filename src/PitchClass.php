<?php declare(strict_types=1);

namespace MrCodefinger\TwelveTones;

use InvalidArgumentException;

final class PitchClass
{
    /** @var list<int> */
    public const CIRCLE_OF_FIFTHS = [0, 7, 2, 9, 4, 11, 6, 1, 8, 3, 10, 5];

    /** @var list<int> */
    public const CIRCLE_OF_FOURTHS = [0, 5, 10, 3, 8, 1, 6, 11, 4, 9, 2, 7];

    private const SHARP_NAMES = ['C', 'C#', 'D', 'D#', 'E', 'F', 'F#', 'G', 'G#', 'A', 'A#', 'B'];

    private const FLAT_NAMES = ['C', 'Db', 'D', 'Eb', 'E', 'F', 'Gb', 'G', 'Ab', 'A', 'Bb', 'B'];

    private const NOTE_OFFSETS = [
        'C' => 0,
        'D' => 2,
        'E' => 4,
        'F' => 5,
        'G' => 7,
        'A' => 9,
        'B' => 11,
    ];

    public static function fromString(string $note): int
    {
        if ($note === '') {
            throw new InvalidArgumentException('Note cannot be empty.');
        }

        $letter = $note[0];
        if (!isset(self::NOTE_OFFSETS[$letter])) {
            throw new InvalidArgumentException(sprintf('Invalid note: %s', $note));
        }

        $offset = self::NOTE_OFFSETS[$letter];
        $accidental = substr($note, 1);

        return match ($accidental) {
            '' => $offset,
            '#' => ($offset + 1) % 12,
            '##' => ($offset + 2) % 12,
            'b' => ($offset + 11) % 12,
            'bb' => ($offset + 10) % 12,
            default => throw new InvalidArgumentException(sprintf('Invalid note: %s', $note)),
        };
    }

    public static function toString(int $pitchClass, bool $useFlats): string
    {
        $normalized = (($pitchClass % 12) + 12) % 12;

        return $useFlats
            ? self::FLAT_NAMES[$normalized]
            : self::SHARP_NAMES[$normalized];
    }
}
