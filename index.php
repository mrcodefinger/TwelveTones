<?php

/**
 * Class RandomValue
 */
final class RandomValue {
	/**
	 * @var array
	 */
	private $values;

	/**
	 * RandomValue constructor.
	 *
	 * @param array $values
	 */
	public function __construct( array $values ) {
		$this->values = $values;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return $this->values[ rand( 0, count( $this->values ) - 1 ) ];
	}
}

/**
 * Class ShuffleArray
 */
final class ShuffleArray {

	/**
	 * @var array
	 */
	private $values;

	/**
	 * ShuffleArray constructor.
	 *
	 * @param array $values
	 */
	public function __construct( array $values ) {
		$this->values = $values;

	}

	/**
	 * @return string
	 */
	public function __toString() {
		return join( " ", $this->getValue() );
	}

	/**
	 * @return array
	 */
	public function getValue() {
		$values = $this->values;
		shuffle( $values );

		return $values;
	}
}

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
