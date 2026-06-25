<?php declare(strict_types=1);

namespace MrCodefinger\TwelveTones\Service;

final class ShuffleArray
{
    /** @var list<string|RandomValue> */
    private array $values;

    /** @param list<string|RandomValue> $values */
    public function __construct(array $values)
    {
        $this->values = $values;
    }

    public function __toString(): string
    {
        return implode(' ', array_map('strval', $this->getValue()));
    }

    /** @return list<string|RandomValue> */
    public function getValue(): array
    {
        $values = $this->values;
        shuffle($values);

        return $values;
    }
}
