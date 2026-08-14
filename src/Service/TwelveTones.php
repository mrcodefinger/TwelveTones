<?php declare(strict_types=1);

namespace MrCodefinger\TwelveTones\Service;

use MrCodefinger\TwelveTones\OrderMode;
use MrCodefinger\TwelveTones\PitchClass;

final class TwelveTones
{
    /** @var list<string|RandomValue> */
    private array $values;

    /** @param list<string|RandomValue> $values */
    public function __construct(
        array $values,
        private OrderMode $order = OrderMode::Random,
        private string $start = 'C',
    ) {
        $this->values = $values;
        PitchClass::fromString($this->start);
    }

    public function __toString(): string
    {
        return implode(' ', $this->getValue());
    }

    /** @return list<string> */
    public function getValue(): array
    {
        $step = $this->order->step();
        $ordered = $step === null
            ? $this->shuffle($this->values)
            : $this->sortByCircle(
                $this->values,
                PitchClass::intervalCycle(PitchClass::fromString($this->start), $step),
            );

        return array_map(fn (string|RandomValue $tone): string => $this->format($tone), $ordered);
    }

    /** @param list<string|RandomValue> $values */
    private function shuffle(array $values): array
    {
        shuffle($values);

        return $values;
    }

    /**
     * @param list<string|RandomValue> $values
     * @param list<int> $circle
     *
     * @return list<string|RandomValue>
     */
    private function sortByCircle(array $values, array $circle): array
    {
        usort(
            $values,
            fn (string|RandomValue $left, string|RandomValue $right): int =>
                array_search($this->pitchClassOf($left), $circle, true)
                <=> array_search($this->pitchClassOf($right), $circle, true),
        );

        return $values;
    }

    private function pitchClassOf(string|RandomValue $tone): int
    {
        if ($tone instanceof RandomValue) {
            return PitchClass::fromString($tone->getValues()[0]);
        }

        return PitchClass::fromString($tone);
    }

    private function format(string|RandomValue $tone): string
    {
        if ($tone instanceof RandomValue) {
            return $tone->format($this->order, $this->useFlats());
        }

        return $tone;
    }

    private function useFlats(): bool
    {
        $accidental = substr($this->start, 1);

        return match ($accidental) {
            '#', '##' => false,
            'b', 'bb' => true,
            default => $this->order->prefersFlats(),
        };
    }
}
