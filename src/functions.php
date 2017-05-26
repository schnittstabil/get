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
