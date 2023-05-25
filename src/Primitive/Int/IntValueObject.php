<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Primitive\Int;

use Adrigar94\ValueObjectCraft\ValueObject;

abstract class IntValueObject implements ValueObject
{
    protected int $value;

    public function __construct(int $value)
    {
        $this->ensureIsValid($value);
        $this->value = $value;
    }

    abstract protected static function getMinValue(): int;

    abstract protected static function getMaxValue(): int;

    public function value(): int
    {
        return $this->value;
    }

    protected function ensureIsValid(int $value): void
    {
        $this->ensureIsMinValueValid($value);
        $this->ensureIsMaxValueValid($value);
    }

    protected function ensureIsMinValueValid(int $value): void
    {
        $minValue = $this->getMinValue();

        if ($value < $minValue) {
            throw new IntTooSmallException($minValue);
        }
    }

    protected function ensureIsMaxValueValid(int $value): void
    {
        $maxValue = $this->getMaxValue();

        if ($value > $maxValue) {
            throw new IntTooLargeException($maxValue);
        }
    }

    public function __toString(): string
    {
        return (string)$this->value();
    }

    public function jsonSerialize(): int
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
        return new static((int)$value);
    }

    public function toNative(): int
    {
        return $this->value();
    }
}