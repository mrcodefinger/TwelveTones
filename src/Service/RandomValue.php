<?php declare(strict_types=1);

namespace MrCodefinger\TwelveTones\Service;

use MrCodefinger\TwelveTones\OrderMode;
use MrCodefinger\TwelveTones\PitchClass;

final class RandomValue
{
    /** @var non-empty-list<string> */
    private array $values;

    /** @param non-empty-list<string> $values */
    public function __construct(array $values)
    {
        $this->values = $values;
    }

    /** @return non-empty-list<string> */
    public function getValues(): array
    {
        return $this->values;
    }

    public function __toString(): string
    {
        return $this->format(OrderMode::Random);
    }

    public function format(OrderMode $mode): string
    {
        $pitchClass = PitchClass::fromString($this->values[0]);

        return match ($mode) {
            OrderMode::Random => $this->values[random_int(0, count($this->values) - 1)],
            OrderMode::Fifths => PitchClass::toString($pitchClass, useFlats: false),
            OrderMode::Fourths => PitchClass::toString($pitchClass, useFlats: true),
        };
    }
}
