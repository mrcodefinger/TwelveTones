## TwelveTones

This script displays all twelve tones in random order.

Examples:

```
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
```

`array_map("printf", $tones->getValue());`

```
foreach($tones->getValue() as $tone) {
     echo $tone . " ";
 }
 echo $tones;
 ```
