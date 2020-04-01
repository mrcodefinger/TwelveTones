<?php

include __DIR__ . '/src/Service/ShuffleArray.php';
include __DIR__ . '/src/Service/RandomValue.php';

use MrCodefinger\TwelveTones\Service\ShuffleArray;
use MrCodefinger\TwelveTones\Service\RandomValue;

$tones = new ShuffleArray( [
	"A",
	"B",
	"C",
	"D",
	"E",
	"F",
	"G",
	new RandomValue( [ "Ab", "G#" ] ),
	new RandomValue( [ "Bb", "A#" ] ),
	new RandomValue( [ "C#", "Db" ] ),
	new RandomValue( [ "D#", "Eb" ] ),
	new RandomValue( [ "F#", "Gb" ] ),
] );

//array_map("printf", $tones->getValue());

/*foreach($tones->getValue() as $tone) {
    echo $tone . " ";
}*/

echo $tones;
