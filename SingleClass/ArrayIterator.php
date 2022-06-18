<?php
/**
 * 
 * 
 */


namespace HappyLin\OldPlugin\SingleClass;


class ArrayIterator implements \Iterator, \ArrayAccess
{
    private $position = 0;
    private $container = array();


    public function __construct() {
        $this->container = array(
            "zero",
            "one" ,
            "two",
            "three",
        );
    }




    function rewind() {
        $this->position = 0;
    }

    function current() {
        return $this->container[$this->position];
    }

    function key() {
        return $this->position;
    }

    function next() {
        ++$this->position;
    }

    function valid() {
        return isset($this->container[$this->position]);
    }


    

    public function offsetSet($offset, $value) {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }


    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }


    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }


    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }








}












