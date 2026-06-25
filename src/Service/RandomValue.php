<?php declare(strict_types=1);

namespace MrCodefinger\TwelveTones\Service;

final class RandomValue
{
    /** @var non-empty-list<string> */
    private array $values;

    /** @param non-empty-list<string> $values */
    public function __construct(array $values)
    {
        $this->values = $values;
    }

    public function __toString(): string
    {
        return $this->values[random_int(0, count($this->values) - 1)];
    }
}
