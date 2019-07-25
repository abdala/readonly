<?php

namespace Abdala;

use InvalidArgumentException;

class InvalidVisibility extends InvalidArgumentException
{
    public static function properties(array $properties) : self
    {
        $names = array_map(function($property) {
            return $property->name;
        }, $properties);

        return new static(sprintf('Invalid public properties (%s). All properties should be private.', implode(',', $names)));
    }
}
