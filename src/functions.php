<?php

namespace Schnittstabil\Get;

if (!function_exists('Schnittstabil\Get\value')) {
    /**
     * Return array values and object properties.
     *
     * @param string|int|mixed[] $path    the path
     * @param object|array|null  $target  the target
     * @param mixed              $default default value if $path is not valid
     *
     * @return mixed the value determined by `$path` or otherwise `$default`
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    function value($path, $target, $default = null)
    {
        return Get::value($path, $target, $default);
    }
}

if (!function_exists('Schnittstabil\Get\valueOrFail')) {
    /**
     * Return array values and object properties.
     *
     * @param string|int|mixed[] $path    the path
     * @param object|array|null  $target  the target
     * @param mixed              $message exception message
     *
     * @throws \OutOfBoundsException if the `$path` does not determine a member of `$target`
     *
     * @return mixed the value determined by `$path`
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    function valueOrFail($path, $target, $message = null)
    {
        return Get::valueOrFail($path, $target, $message);
    }
}

if (!function_exists('Schnittstabil\Get\getValue')) {
    /**
     * @deprecated Use `Schnittstabil\Get\value()` instead of `Schnittstabil\Get\getValue()`
     */
    function getValue($path, $target, $default = null)
    {
        return value($path, $target, $default);
    }
}

if (!function_exists('Schnittstabil\Get\getValueOrFail')) {
    /**
     * @deprecated Use `Schnittstabil\Get\valueOrFail()` instead of `Schnittstabil\Get\getValueOrFail()`
     */
    function getValueOrFail($path, $target, $message = null)
    {
        return valueOrFail($path, $target, $message);
    }
}

if (!function_exists('Schnittstabil\Get\typed')) {
    /**
     * Converts a string value to a PHP typed value.
     *
     * @param mixed  $value
     * @return mixed
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    function typed($value)
    {
        if (!is_string($value)) {
            return $value;
        }

        if (1 < $len = strlen($value)) {
            switch ($value[0] . $value[$len - 1]) {
                case "''":
                case '""':
                    return substr($value, 1, -1);
            }
        }

        if (false !== $int = filter_var($value, FILTER_VALIDATE_INT)) {
            return $int;
        }

        if (false !== $float = filter_var($value, FILTER_VALIDATE_FLOAT)) {
            return $float;
        }

        // because FILTER_VALIDATE_BOOLEAN sucks...
        switch (strtolower($value)) {
            case 'true':
            case 'on':
            case 'yes':
                return true;
            case 'false':
            case 'off':
            case 'no':
                return false;
            case 'null':
                return;
        }

        return $value;
    }
}

if (!function_exists('Schnittstabil\Get\env')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param string $varname   the variable name
     * @param mixed  $default   default value if `$varname` is not valid
     * @param mixed  $typed     convert environment value to a PHP typed value
     * @param bool   $localOnly return only values of local environment variables
     *
     * @return mixed the environment value determined by `$varname` or otherwise `$default`
     *
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    function env($varname, $default = null, $typed = true, $localOnly = false)
    {
        if (false === $value = getenv($varname, $localOnly)) {
            return $default;
        }

        return $typed ? typed($value) : $value;
    }
}

if (!function_exists('Schnittstabil\Get\envOrFail')) {
    /**
     * Gets the value of an environment variable.
     *
     * @param string $varname   the variable name
     * @param mixed  $message   exception message
     * @param mixed  $typed     convert environment value to a PHP typed value
     * @param bool   $localOnly return only values of local environment variables
     *
     * @throws OutOfBoundsException if the `$varname` does not determine an environment value
     *
     * @return mixed the environment value determined by `$varname`
     *
     * @SuppressWarnings(PHPMD.StaticAccess)
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     */
    function envOrFail($varname, $message = null, $typed = true, $localOnly = false)
    {
        if (false === $value = getenv($varname, $localOnly)) {
            throw OutOfBoundsException::create($varname, getenv(), $message);
        }

        return $typed ? typed($value) : $value;
    }
}
