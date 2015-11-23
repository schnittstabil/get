<?php

namespace Schnittstabil;

class Get
{
    public static function value($keys, $objectOrArray, $default = null)
    {
        if (!is_array($keys)) {
            $keys = [$keys];
        }

        $value = $objectOrArray;

        foreach ($keys as $key) {
            if (is_array($value)) {
                if (isset($value[$key])) {
                    $value = $value[$key];
                } else {
                    return $default;
                }
            } else {
                if (isset($value->$key)) {
                    $value = $value->$key;
                } else {
                    return $default;
                }
            }
        }

        return $value;
    }
}
