<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Primitive\Enum;

use Adrigar94\ValueObjectCraft\ValueObject;
use ReflectionClass;
use RuntimeException;

abstract class EnumValueObject implements ValueObject
{
    protected string $value;

    abstract protected function valueMapping(): array;

    public function __construct(string $value)
    {
        $this->ensureIsValid($value);
        $this->value = $value;
    }

    protected function ensureIsValid(string $value): void
    {
        if (!array_key_exists($value, $this->valueMapping())) {
            throw new EnumOptionNotAvailableException($value);
        }
    }

    public function value(): string
    {
        return $this->value;
    }

    public static function values(): array
    {
        $class = static::class;
        $reflected = new ReflectionClass($class);
        return $reflected->getConstants();
    }

    public static function __callStatic(string $name, $args)
    {
        return new static(self::values()[$name]);
    }

    public function isSame(ValueObject $object): bool
    {
        return $this->value == $object->value;
    }

    public static function fromNative($native)
    {
        return new static($native);
    }

    public function toNative()
    {
        return $this->value;
    }

    public function jsonSerialize(): string
    {
        return $this->toNative();
    }

    public function __toString(): string
    {
        return $this->getDisplayedValue();
    }

    public function getDisplayedValue(): string
    {
        $mapping = $this->valueMapping();

        if (isset($mapping[$this->value])) {
            return $mapping[$this->value];
        }

        return $this->value;
    }
}
