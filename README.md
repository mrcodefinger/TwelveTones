## TwelveTones

This library displays all twelve tones in random order or along systematic interval sequences (chromatic, whole tone, minor/major third, circle of fifths, circle of fourths).

Requires PHP 8.2 or later.

```bash
composer install
composer test
php index.php
```

### Usage

```php
use MrCodefinger\TwelveTones\Direction;
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
```

### Order modes

An optional `$start` note (default `C`) rotates the sequence so it begins on that pitch. Random order ignores `$start`. An optional `$direction` (default `Direction::Ascending`) reverses the interval step for descending practice; remaining cycles still start on the next unused chromatic pitch. Chromatic, whole-tone, and third sequences use sharps when ascending and flats when descending (an explicit sharp or flat `$start` still wins).

| Mode | Example from C |
|------|----------------|
| `OrderMode::Random` | shuffled, enharmonic spellings random |
| `OrderMode::Chromatic` | `C C# D D# E F F# G G# A A# B` |
| `OrderMode::Chromatic` descending | `C B Bb A Ab G Gb F E Eb D Db` |
| `OrderMode::WholeTone` | `C D E F# G# A# C# D# F G A B` |
| `OrderMode::WholeTone` descending | `C Bb Ab Gb E D Db B A G F Eb` |
| `OrderMode::MinorThird` | `C D# F# A C# E G A# D F G# B` |
| `OrderMode::MinorThird` descending | `C A Gb Eb Db Bb G E D B Ab F` |
| `OrderMode::MajorThird` | `C E G# C# F A D F# A# D# G B` |
| `OrderMode::MajorThird` descending | `C Ab E Db A F D Bb Gb Eb B G` |
| `OrderMode::Fifths` | `C G D A E B F# C# G# D# A# F` |
| `OrderMode::Fourths` | `C F Bb Eb Ab Db Gb B E A D G` |

```php
$tones = new TwelveTones([...], OrderMode::Fifths);
echo $tones;

$fromEb = new TwelveTones([...], OrderMode::Chromatic, start: 'Eb');

$descending = new TwelveTones([...], OrderMode::MinorThird, direction: Direction::Descending);

foreach ($tones->getValue() as $tone) {
    echo $tone . ' ';
}
```

Intervals that do not visit all twelve pitch classes in one cycle (whole tone, minor third, major third) concatenate the remaining cycles so every key still appears.

`ShuffleArray` is still available as a deprecated alias for random order.

[https://twelvetones.eu/](https://twelvetones.eu/)
