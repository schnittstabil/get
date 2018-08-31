<?php

namespace Schnittstabil\Get\Fixtures;

/**
 * Some class implementing \ArrayAccess.
 */
class GetterObject
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}
