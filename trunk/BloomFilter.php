<?php

include("BitField.php");

class BloomFilter {
    
    public $vector;
    public $max_index;
    
    public function __construct($bit_size, $num_hashes) {
        $this->bit_size = $bit_size;
        $this->num_hashes = $num_hashes;
        $this->vector = new BitField($bit_size);
    }
    
    public function contains($string) {
        foreach($this->_hash_indices($string) as $index) {
            if($this->vector->testbit($index) != 1)
                return false;
        }
        return true;
    }
    
    public function insert($string) {
        foreach($this->_hash_indices($string) as $index) {
            $this->vector->setbit($index);
        }
    }
    
    private function _hash_indices($string) {
        $indices = array();
        for($i=1; $i < ($this->num_hashes + 1); $i++){
            $indices[] = abs(($this->_num_hash_1($string) + $i * $this->_num_hash_2($string)) % $this->bit_size);
        }
        return $indices;
    }
    
    /* A decent fast hash function that returns a number */
    private function _num_hash_1($string) {
        
        $size = strlen($string);
        
        if ($size==0) return 0;

        $chars = str_split($string);
        $i = 0;
        foreach($chars as $char) {
            $i += ($i>>14) + ($char * 0xd2d84a61);
        }
        $i += ($i>>14) + ($size * 0xd2d84a61);
        return $i;
    }

    /* A decent fast hash function that returns a number */
    private function _num_hash_2($string) {
        $val = 0;
        $array = str_split($string);
        foreach($array as $char) {
            $val = ($val << 4) + ord($char);
            $tmp = $val & 0xf0000000;
            if ($tmp != 0) {
                $val = $val ^ ($tmp >> 24);
                $val = $val ^ $tmp;
            }
        }
        return $val;
    }
}
?>