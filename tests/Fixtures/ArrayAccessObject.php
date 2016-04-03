<?php

namespace Schnittstabil\Get\Fixtures;

/**
 * Some class implementing \ArrayAccess.
 */
class ArrayAccessObject implements \ArrayAccess
{
    /**
     * The item container.
     *
     * @var array
     */
    protected $container;

    /**
     * Create new ArrayAccessObject.
     *
     * @param array|null $container prefilled container
     */
    public function __construct(array $container = null)
    {
        $this->container = $container ?: array();
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
