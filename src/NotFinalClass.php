<?php

namespace Abdala;

use RuntimeException;

class NotFinalClass extends RuntimeException
{
    public static function withName($name) : self
    {
        return new static(sprintf('Readonly class [%s] should be final.', $name));
    }
}
