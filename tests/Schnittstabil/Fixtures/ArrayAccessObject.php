<?php

namespace Schnittstabil\Fixtures;

class ArrayAccessObject implements \ArrayAccess
{
    private $container;

    public function __construct(array $array = null)
    {
        $this->container = $array ?: array();
    }

    public function offsetSet($offset, $value)
    {
        if ($offset === null) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    public function offsetExists($offset)
    {
        return isset($this->container[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->container[$offset]) ? $this->container[$offset] : null;
    }

    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }
}
