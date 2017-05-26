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
     * @param array $container prefilled container
     */
    public function __construct(array $container = array())
    {
        $this->container = $container;
    }

    public function offsetSet($offset, $value)
    {
        if ($offset === null) {
            $this->container[] = $value;

            return;
        }

        $this->container[$offset] = $value;
    }

    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->container);
    }

    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->container[$offset] : null;
    }

    public function offsetUnset($offset)
    {
        unset($this->container[$offset]);
    }
}
