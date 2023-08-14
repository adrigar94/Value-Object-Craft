<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Domain\Name;

use Adrigar94\ValueObjectCraft\ValueObject;

class FullnameValueObject implements ValueObject
{

    protected NameValueObject $name;
    protected NameValueObject $surname;

    public function __construct(NameValueObject $name, NameValueObject $surname)
    {
        $this->name = $name;
        $this->surname = $surname;
    }

    public static function create(string $name, string $surname): self
    {
        return new Self(new NameValueObject($name), new NameValueObject($surname));
    }

    public function name(): NameValueObject
    {
        return $this->name;
    }

    public function surname(): NameValueObject
    {
        return $this->surname;
    }

    public function isSame(ValueObject $object): bool
    {
        if (!$object instanceof self) {
            return false;
        }

        return $this->name()->isSame($object->name()) and $this->surname()->isSame($object->surname());
    }


    public static function fromNative($value): self
    {
        $decoded = json_decode($value, true);
        $name = new NameValueObject($decoded['name']);
        $surname = new NameValueObject($decoded['surname']);
        return new static($name, $surname);
    }

    public function toNative(): string
    {
        return $this->jsonSerialize();
    }

    public function __toString(): string
    {
        return $this->name() . ' ' . $this->surname();
    }

    public function jsonSerialize(): string
    {
        return json_encode(['name' => $this->name(), 'surname' => $this->surname()]);
    }
}
