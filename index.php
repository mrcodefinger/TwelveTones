<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use MrCodefinger\TwelveTones\Service\RandomValue;
use MrCodefinger\TwelveTones\Service\ShuffleArray;

$tones = new ShuffleArray([
    'A',
    'B',
    'C',
    'D',
    'E',
    'F',
    'G',
    new RandomValue(['Ab', 'G#']),
    new RandomValue(['Bb', 'A#']),
    new RandomValue(['C#', 'Db']),
    new RandomValue(['D#', 'Eb']),
    new RandomValue(['F#', 'Gb']),
]);

echo $tones;
