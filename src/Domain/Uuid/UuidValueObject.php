<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Domain\Uuid;

use Adrigar94\ValueObjectCraft\ValueObject;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

class UuidValueObject implements ValueObject
{

    public function __construct(protected string $value)
    {
        $this->ensureIsValidUuid($value);
    }

    public static function random(): self
    {
        return new static(Uuid::uuid4()->toString());
    }

    public function value(): string
    {
        return $this->value;
    }

    public function isSame(ValueObject $object): bool
    {
        if (!$object instanceof self) {
            return false;
        }
        return $this->value() === $object->value();
    }

    public function __toString(): string
    {
        return $this->value();
    }

    public function jsonSerialize(): string
    {
        return $this->value();
    }

    private function ensureIsValidUuid(string $id): void
    {
        if (!Uuid::isValid($id)) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', static::class, $id));
        }
    }

    public static function fromNative($value)
    {
        return new static($value);
    }

    public function toNative()
    {
        return $this->value();
    }
}
