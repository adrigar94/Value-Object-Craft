<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Primitive\Enum;

use Adrigar94\ValueObjectCraft\ValueObject;

abstract class EnumArrayValueObject implements ValueObject
{
    protected array $values;

    abstract static protected function enumClass(): string;

    public function __construct(array $values)
    {
        $this->ensureIsValid($values);
        $this->values = $values;
    }

    public function values(): array
    {
        return $this->values;
    }

    public function add($item): void
    {
        $this->ensureIsValid([$item]);
        $this->values[] = $item;
    }

    public function isSame(ValueObject $object): bool
    {
        if (!$object instanceof self) {
            return false;
        }
        $array1 = $this->values();
        $array2 = $object->values();
        
        array_multisort($array1);
        array_multisort($array2);
        return ( serialize($array1) === serialize($array2) );

        return $this->values() === $object->values();
    }

    public static function fromNative($values): self
    {
        $enumValues = [];
        $class = static::enumClass();
        foreach($values as $value){
            $enumValues[] = new $class($value);
        }

        return new static($enumValues);
    }

    public function toNative()
    {
        $values = [];
        foreach($this->values() as $value)
        {
            $values[] = $value->toNative();
        }

        return $values;
    }

    public function jsonSerialize(): array
    {
        return $this->toNative();
    }

    
    public function __toString(): string
    {
        $values = [];
        foreach($this->values() as $value){
            $values[] = $value->getDisplayedValue();
        }
        return implode(", ",$values);
    }

    protected function ensureIsValid(array $value): void
    {
        $class = $this->enumClass();
        foreach ($value as $item) {
            if (!$item instanceof $class) {
                throw new InvalidEnumArrayException();
            }
        }
    }
}