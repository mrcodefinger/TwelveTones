<?php

namespace MrCodefinger\TwelveTones\Service;

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