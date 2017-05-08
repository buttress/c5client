<?php

namespace Buttress\ConcreteClient\Exception;

class VersionMismatchException extends Exception
{
    protected $expected = null;
    protected $given = null;

    public static function expected($expected, $given = null, $previous = null)
    {
        return new static("Invalid Version, expected \"{$expected}\"" . ($given ? " got \"{$given}\"" : ''), $previous);
    }
}
