<?php

namespace Schnittstabil;

class Get
{
    /**
     * @param string|int|mixed[] $path
     *
     * @return mixed[] The normalized path
     */
    private static function normalizePath($path)
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
     * @param string|int|mixed[] $path
     * @param object|array       $objectOrArray
     * @param \Closure           $outOfBoundsHandler
     */
    private static function call($path, $objectOrArray, $outOfBoundsHandler)
    {
        $trace = [];
        $value = $objectOrArray;

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

            return $outOfBoundsHandler($trace);
        }

        return $value;
    }

    /**
     * Return array values and object properties.
     *
     * @param string|int|mixed[] $path
     * @param object|array       $objectOrArray
     * @param mixed              $default       Default value if $path is not valid.
     *
     * @return mixed The value determined by $path or otherwise $default.
     */
    public static function value($path, $objectOrArray, $default = null)
    {
        return self::call($path, $objectOrArray, function () use ($default) {
            return $default;
        });
    }

    /**
     * Return array values and object properties.
     *
     * @param string|int|mixed[] $path
     * @param object|array       $objectOrArray
     * @param mixed              $message       Exception message.
     *
     * @throws \OutOfBoundsException if the $path does not determine a member of $objectOrArray.
     *
     * @return mixed The value determined by $path.
     */
    public static function valueOrFail($path, $objectOrArray, $message = null)
    {
        return self::call($path, $objectOrArray, function ($path) use (&$message) {
            if ($message === null) {
                $message = 'Cannot get %s.';
            }

            throw new \OutOfBoundsException(sprintf($message, json_encode($path)));
        });
    }
}
