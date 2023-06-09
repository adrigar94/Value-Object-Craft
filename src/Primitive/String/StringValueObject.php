<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Primitive\String;


use Adrigar94\ValueObjectCraft\ValueObject;

abstract class StringValueObject implements ValueObject
{
    protected string $value;

    public function __construct(string $value)
    {
        $this->ensureIsValid($value);
        $this->value = $value;
    }

    abstract protected static function getMinLength(): int;

    abstract protected static function getMaxLength(): int;

    public function value(): string
    {
        return $this->value;
    }

    protected function ensureIsValid(string $value): void
    {
        $this->ensureIsMinLengthValid($value);
        $this->ensureIsMaxLengthValid($value);
    }

    protected function ensureIsMinLengthValid(string $value): void
    {
        $minLength = $this->getMinLength();

        if (strlen($value) < $minLength) {
            $className = static::class;
            throw new StringTooShortException($minLength, $className);
        }
    }

    protected function ensureIsMaxLengthValid(string $value): void
    {
        $maxLength = $this->getMaxLength();

        if (strlen($value) > $maxLength) {
            $className = static::class;
            throw new StringTooLongException($maxLength, $className);
        }
    }

    public function __toString(): string
    {
        return $this->value();
    }

    public function jsonSerialize(): string
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
        return new static($value);
    }

    public function toNative(): string
    {
        return $this->value();
    }
}