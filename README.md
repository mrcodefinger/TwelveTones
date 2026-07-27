## TwelveTones

This library displays all twelve tones in random order, circle of fifths, or circle of fourths.

Requires PHP 8.2 or later.

```bash
composer install
composer test
php index.php
```

### Usage

```php
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

| Mode | Example output |
|------|----------------|
| `OrderMode::Random` | shuffled, enharmonic spellings random |
| `OrderMode::Fifths` | `C G D A E B F# C# G# D# A# F` |
| `OrderMode::Fourths` | `C F Bb Eb Ab Db Gb B E A D G` |

```php
$tones = new TwelveTones([...], OrderMode::Fifths);
echo $tones;

foreach ($tones->getValue() as $tone) {
    echo $tone . ' ';
}
```

`ShuffleArray` is still available as a deprecated alias for random order.

[https://twelvetones.eu/](https://twelvetones.eu/)
