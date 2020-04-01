<?php

namespace MrCodefinger\TwelveTones\Service;

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
