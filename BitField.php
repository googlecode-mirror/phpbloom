<?php

/* Only contains enough to support BloomFilter */

class BitField {
    public $size;
    public $vector;
    const ELEMENT_WIDTH = 31;
    
    public function __construct($size) {
        $this->vector = array_pad(array(), (($size-1) / self::ELEMENT_WIDTH) + 1, 0);
    }
    
    public function setbit($position) {
        $this->vector[$position / self::ELEMENT_WIDTH] |= 1 << ($position % self::ELEMENT_WIDTH);
    }
    
    public function testbit($position) {
        return ($this->vector[$position / self::ELEMENT_WIDTH] & 1 << ($position % self::ELEMENT_WIDTH)) > 0 ? 1 : 0;
    }
}
?>