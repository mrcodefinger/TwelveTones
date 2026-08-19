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

    public static function transpose(int $pitchClass, int $semitones): int
    {
        return ((($pitchClass + $semitones) % 12) + 12) % 12;
    }

    /**
     * Transpose a single note name. Without an explicit `$useFlats` the result
     * keeps the accidental style of `$note`; naturals fall back to sharps.
     */
    public static function transposeName(string $note, int $semitones, ?bool $useFlats = null): string
    {
        return self::toString(
            self::transpose(self::fromString($note), $semitones),
            $useFlats ?? self::accidentalPrefersFlats($note) ?? false,
        );
    }

    /**
     * Transpose a whole sequence. Without an explicit `$useFlats` every note
     * keeps its own accidental style, and naturals follow the style of the
     * sequence: flats when it spells flats and no sharps, sharps otherwise.
     *
     * @param list<string> $notes
     * @return list<string>
     */
    public static function transposeSequence(array $notes, int $semitones, ?bool $useFlats = null): array
    {
        $fallback = $useFlats ?? self::sequencePrefersFlats($notes);

        return array_map(
            static fn (string $note): string => self::transposeName(
                $note,
                $semitones,
                $useFlats ?? self::accidentalPrefersFlats($note) ?? $fallback,
            ),
            $notes,
        );
    }

    /**
     * Build a 12-tone sequence by stepping `$step` semitones from `$start`.
     * When the interval does not generate all twelve pitch classes, remaining
     * cycles start at the next unused chromatic pitch.
     *
     * @return list<int>
     */
    public static function intervalCycle(int $start, int $step): array
    {
        $start = (($start % 12) + 12) % 12;
        $step = (($step % 12) + 12) % 12;
        if ($step === 0) {
            throw new InvalidArgumentException('Step cannot be a multiple of 12.');
        }

        $visited = [];
        $result = [];
        $cycleStart = $start;

        while (count($result) < 12) {
            $pc = $cycleStart;
            do {
                $result[] = $pc;
                $visited[$pc] = true;
                $pc = ($pc + $step) % 12;
            } while ($pc !== $cycleStart);

            if (count($result) >= 12) {
                break;
            }

            $cycleStart = ($cycleStart + 1) % 12;
            while (isset($visited[$cycleStart])) {
                $cycleStart = ($cycleStart + 1) % 12;
            }
        }

        return $result;
    }

    /** Null when the note carries no accidental. */
    private static function accidentalPrefersFlats(string $note): ?bool
    {
        return match (substr($note, 1)) {
            'b', 'bb' => true,
            '#', '##' => false,
            default => null,
        };
    }

    /** @param list<string> $notes */
    private static function sequencePrefersFlats(array $notes): bool
    {
        $flats = false;

        foreach ($notes as $note) {
            $prefersFlats = self::accidentalPrefersFlats($note);
            if ($prefersFlats === false) {
                return false;
            }
            if ($prefersFlats === true) {
                $flats = true;
            }
        }

        return $flats;
    }
}
