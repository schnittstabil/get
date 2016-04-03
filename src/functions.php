<?php

namespace Schnittstabil\Get;

if (!function_exists('Schnittstabil\Get\getValue')) {
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
    function getValue($path, $target, $default = null)
    {
        return Get::value($path, $target, $default);
    }
}

if (!function_exists('Schnittstabil\Get\getValueOrFail')) {
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
    function getValueOrFail($path, $target, $message = null)
    {
        return Get::valueOrFail($path, $target, $message);
    }
}
