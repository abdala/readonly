<?php

namespace Abdala;

use InvalidArgumentException;

class RequiredProperty extends InvalidArgumentException
{
    public static function withName($name) : self
    {
        return new static(sprintf('Required property: %s', $name));
    }
}

