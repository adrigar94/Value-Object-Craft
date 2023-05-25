<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Primitive\Float;

use Adrigar94\ValueObjectCraft\ValueObject;

abstract class FloatValueObject implements ValueObject
{
    protected float $value;

    public function __construct(float $value)
    {
        $this->ensureIsValid($value);
        $this->value = $value;
    }

    abstract protected static function getMinValue(): float;

    abstract protected static function getMaxValue(): float;

    public function value(): float
    {
        return $this->value;
    }

    protected function ensureIsValid(float $value): void
    {
        $this->ensureIsMinValueValid($value);
        $this->ensureIsMaxValueValid($value);
    }

    protected function ensureIsMinValueValid(float $value): void
    {
        $minValue = $this->getMinValue();

        if ($value < $minValue) {
            throw new FloatTooSmallException($minValue);
        }
    }

    protected function ensureIsMaxValueValid(float $value): void
    {
        $maxValue = $this->getMaxValue();

        if ($value > $maxValue) {
            throw new FloatTooLargeException($maxValue);
        }
    }

    public function __toString(): string
    {
        return (string) $this->value();
    }

    public function jsonSerialize(): float
    {
        return $this->value();
    }

    public function isSame(ValueObject $object): bool
    {
        if (!$object instanceof self) {
            return false;
        }

        return $this->value() === $object->value();
    }

    public static function fromNative($value): self
    {
        return new static((float) $value);
    }

    public function toNative(): float
    {
        return $this->value();
    }
}