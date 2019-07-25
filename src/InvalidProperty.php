<?php

namespace Abdala;

use TypeError;

class InvalidProperty extends TypeError
{
    public static function withName($name) : self
    {
        return new static(sprintf('Invalid type for property: %s. All non-scalar properties should use Readonly trait', $name));
    }
}
