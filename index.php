<?php declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use MrCodefinger\TwelveTones\OrderMode;
use MrCodefinger\TwelveTones\Service\RandomValue;
use MrCodefinger\TwelveTones\Service\TwelveTones;

$tones = new TwelveTones([
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
], OrderMode::Random);

echo $tones;
