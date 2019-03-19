<?php

class RandomValue {

  private $values;

  public function __construct(array $values) {
    $this->values = $values;
  }

  public function __toString() {
    return $this->values[rand(0, count($this->values) - 1)];
  }
}

class ShuffleArray {

  private $values;

  public function __construct(array $values) {
    $this->values = $values;

  }

  public function __toString() {
    return join(" ", $this->getValue());
  }

  public function getValue() {
    $values = $this->values;
    shuffle($values);
    return $values;
  }
}

$tones =  new ShuffleArray([
  "A",
  "B",
  "C",
  "D",
  "E",
  "F",
  "G",
  new RandomValue(["Ab", "G#"]),
  new RandomValue(["Bb", "A#"]),
  new RandomValue(["C#", "Db"]),
  new RandomValue(["D#", "Eb"]),
  new RandomValue(["F#", "Gb"]),
]);

//array_map("printf", $tones->getValue());

/*foreach($tones->getValue() as $tone) {
    echo $tone . " ";
}*/

echo $tones;
