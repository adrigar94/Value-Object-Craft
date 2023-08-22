<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Domain\Price;

use Adrigar94\ValueObjectCraft\Domain\Currency\CurrencyValueObject;
use Adrigar94\ValueObjectCraft\ValueObject;

class PriceValueObject implements ValueObject
{

    private function __construct(
        private int $price,
        private CurrencyValueObject $currency
    ) {
    }

    public static function createPrice(float $price, CurrencyValueObject $currency): self
    {
        return new static((int) ($price * 100), $currency);
    }

    public function getPrice(): float
    {
        return $this->price / 100;
    }

    public function getCurrency(): CurrencyValueObject
    {
        return $this->currency;
    }

    public function isSame(ValueObject $object): bool
    {
        return $object->__toString() == $this->__toString();
    }

    public static function fromNative($native)
    {
        return new static($native['price'], CurrencyValueObject::fromNative($native['currency']));
    }

    public function toNative(): array
    {
        return [
            'price' => $this->price,
            'currency' => $this->currency->toNative()
        ];
    }

    public function __toString(): string
    {
        return $this->getPrice() . $this->currency;
    }

    public function jsonSerialize(): array
    {
        return $this->toNative();
    }
}
