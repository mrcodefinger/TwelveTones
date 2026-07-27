<?php declare(strict_types=1);

namespace MrCodefinger\TwelveTones\Service;

use MrCodefinger\TwelveTones\OrderMode;

/** @deprecated Use TwelveTones instead */
final class ShuffleArray extends TwelveTones
{
    /** @param list<string|RandomValue> $values */
    public function __construct(array $values)
    {
        parent::__construct($values, OrderMode::Random);
    }
}
