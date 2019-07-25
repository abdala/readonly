<?php

namespace Abdala;

use RuntimeException;

class ReadonlyProperty extends RuntimeException
{
    public static function withName($name) : self
    {
        return new static(sprintf('Readonly property: %s', $name));
    }
}
