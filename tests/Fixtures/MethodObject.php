<?php

namespace Schnittstabil\Get\Fixtures;

/**
 * Some class implementing \ArrayAccess.
 */
class MethodObject
{
    protected $value;

    public function __construct($value)
    {
        $this->value = $value;
    }

    public function value()
    {
        return $this->value;
    }
}
