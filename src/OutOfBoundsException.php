<?php

namespace Schnittstabil\Get;

class OutOfBoundsException extends \OutOfBoundsException implements Exception
{
    protected $path;
    protected $target;

    public function __construct($message = '', $code = 0, \Exception $previous = null, $path = null, $target = null)
    {
        parent::__construct($message, $code, $previous);
        $this->path = $path;
        $this->target = $target;
    }

    public static function create($path = null, $target = null, $message = null, $code = 0, \Exception $previous = null)
    {
        if ($message === null) {
            $message = sprintf('Cannot get %s from %s.', json_encode($path), print_r($target, true));
        }

        return new static($message, $code, $previous, $path, $target);
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getTarget()
    {
        return $this->target;
    }
}
