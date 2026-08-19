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

    /** Diatonic steps for each ascending interval in semitones. Tritone is an augmented fourth. */
    private const ASCENDING_STEPS = [0, 1, 1, 2, 2, 3, 3, 4, 5, 5, 6, 6];

    /**
     * Transpose a single note name. Without an explicit `$useFlats` the result
     * is spelled as that interval: a minor third from G is Bb, not A#.
     */
    public static function transposeName(string $note, int $semitones, ?bool $useFlats = null): string
    {
        $target = self::transpose(self::fromString($note), $semitones);
        if ($useFlats !== null) {
            return self::toString($target, $useFlats);
        }

        return self::spellInterval($note, $semitones, $target);
    }

    /**
     * Transpose a whole sequence. Without an explicit `$useFlats` every note
     * is spelled as the given interval from its source name.
     *
     * @param list<string> $notes
     * @return list<string>
     */
    public static function transposeSequence(array $notes, int $semitones, ?bool $useFlats = null): array
    {
        return array_map(
            static fn (string $note): string => self::transposeName($note, $semitones, $useFlats),
            $notes,
        );
    }

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

    /**
     * Spell `$target` as the diatonic interval of `$semitones` from `$note`.
     * A descending tritone is written as a diminished fifth.
     */
    private static function spellInterval(string $note, int $semitones, int $target): string
    {
        $interval = ((abs($semitones) % 12) + 12) % 12;
        if ($interval === 0) {
            return $note;
        }

        $letters = array_keys(self::NOTE_OFFSETS);
        $letterIndex = array_search($note[0], $letters, true);
        $steps = self::ASCENDING_STEPS[$interval];
        if ($semitones < 0 && $interval === 6) {
            $steps = 4;
        }

        $direction = $semitones < 0 ? -1 : 1;
        $destLetter = $letters[($letterIndex + $direction * $steps + 7) % 7];
        $accidental = (($target - self::NOTE_OFFSETS[$destLetter] + 6) % 12) - 6;

        return match ($accidental) {
            -2 => $destLetter . 'bb',
            -1 => $destLetter . 'b',
            0 => $destLetter,
            1 => $destLetter . '#',
            2 => $destLetter . '##',
            default => self::toString($target, $accidental < 0),
        };
    }
}
