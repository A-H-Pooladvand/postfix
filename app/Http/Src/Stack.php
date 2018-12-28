<?php

namespace App\Http\Src;

class Stack
{
    private $array = array();

    public function push($item)
    {
        $this->array[] = $item;
    }

    public function pop()
    {
        return array_pop($this->array);
    }

    public function peek()
    {
        $values = array_values($this->array);

        return end($values);
    }

    public function isEmpty()
    {
        return empty($this->array);
    }

    public function get()
    {
        return $this->array;
    }
}