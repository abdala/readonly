<?php

declare(strict_types=1);

namespace Abdala;

use Exception;
use ReflectionClass;
use ReflectionProperty;
use TypeError;

trait Readonly
{
    private bool $isConstructorCall = true;

    public function __construct(...$args)
    {
        $reflection        = new ReflectionClass($this);
        $publicProperties  = $reflection->getProperties(ReflectionProperty::IS_PUBLIC);
        $privateProperties = $reflection->getProperties(ReflectionProperty::IS_PRIVATE);
        $defaultValues     = $reflection->getDefaultProperties();

        if (! $reflection->isFinal()) {
            throw NotFinalClass::withName(get_class($this));
        }

        if ($publicProperties) {
            throw InvalidVisibility::properties($publicProperties);
        }

        foreach ($privateProperties as $index => $property) {
            $propertyName = $property->name;
            $propertyType = $property->getType();

            if (isset($args[$index])) {
                $value = $args[$index];
            } else {
                if (empty($defaultValues[$propertyName]) && ! $propertyType->allowsNull()) {
                    throw RequiredProperty::withName($propertyName);
                }

                $value = $defaultValues[$propertyName];
            }

            if ($value && ! is_scalar($value) && ! in_array(Readonly::class, class_uses($value))) {
                throw InvalidProperty::withName($propertyName);
            }

            $this->$propertyName = $value;
        }

        $this->isConstructorCall = false;

        $this->assert();
    }

    public function assert()
    {}

    public function __get($name)
    {
        if (! property_exists($this, $name)) {
            trigger_error(sprintf('Undefined property: %s', $name));
        }

        return $this->$name;
    }

    public function __set($name, $value)
    {
        if (! $this->isConstructorCall) {
            throw ReadonlyProperty::withName($name);
        }

        $this->$name = $value;
    }
}
