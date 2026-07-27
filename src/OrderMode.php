<?php declare(strict_types=1);

namespace MrCodefinger\TwelveTones;

enum OrderMode: string
{
    case Random = 'random';
    case Fifths = 'fifths';
    case Fourths = 'fourths';
}
