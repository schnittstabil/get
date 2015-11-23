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
            if (isset($value->$key)) {
                $value = $value->$key;
                continue;
            }

            if (is_array($value) && isset($value[$key])) {
                $value = $value[$key];
                continue;
            }

            return $default;
        }

        return $value;
    }
}
