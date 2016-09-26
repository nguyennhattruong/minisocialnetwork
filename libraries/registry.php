<?php

defined('ACCESS_SYSTEM') or die;

class Registry
{
	public $obj = array();

    public function __set($index, $value) 
    {
        $this->obj[$index] = $value;
    }

    public function __get($index) 
    {
        return $this->obj[$index];
    }

    function __sleep() 
    {
        $this->obj = serialize($this->obj);
    }

    function __wake() 
    {
        $this->obj = unserialize($this->obj);
    }
}

?>