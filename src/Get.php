<?php

namespace Schnittstabil\Get;

/**
 * Get nested array values and object properties.
 */
class Get
{
    /**
     * Normalize property paths.
     *
     * @param string|int|mixed[] $path the path
     *
     * @return mixed[] the normalized path
     */
    public static function normalizePath($path)
    {
        if (is_string($path)) {
            return explode('.', $path);
        }

        if (!is_array($path)) {
            return [$path];
        }

        return $path;
    }

    /**
     * Return array values and object properties.
     *
     * @param string|int|mixed[] $path               the path
     * @param object|array|null  $target             the target
     * @param callable           $outOfBoundsHandler an error handler
     *
     * @throws \OutOfBoundsException `$outOfBoundsHandler` exceptions
     *
     * @return mixed the value determined by `$path`
     */
    protected static function call($path, $target, callable $outOfBoundsHandler)
    {
        $trace = [];
        $value = $target;

        foreach (self::normalizePath($path) as $key) {
            $trace[] = $key;

            if (isset($value->$key)) {
                $value = $value->$key;
                continue;
            }

            if (is_array($value) && isset($value[$key])) {
                $value = $value[$key];
                continue;
            }

            if ($value instanceof \ArrayAccess && $value->offsetExists($key)) {
                $value = $value->offsetGet($key);
                continue;
            }

            return $outOfBoundsHandler($trace);
        }

        return $value;
    }

    /**
     * Return array values and object properties.
     *
     * @param string|int|mixed[] $path    the path
     * @param object|array|null  $target  the target
     * @param mixed              $default default value if $path is not valid
     *
     * @return mixed the value determined by `$path` or otherwise `$default`
     */
    public static function value($path, $target, $default = null)
    {
        return self::call(
            $path,
            $target,
            function () use ($default) {
                return $default;
            }
        );
    }

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
     */
    public static function valueOrFail($path, $target, $message = null)
    {
        return self::call(
            $path,
            $target,
            function ($path) use (&$message) {
                if ($message === null) {
                    $message = 'Cannot get %s.';
                }

                throw new \OutOfBoundsException(sprintf($message, json_encode($path)));
            }
        );
    }
}
