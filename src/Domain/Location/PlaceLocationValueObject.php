<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Domain\Location;

use Adrigar94\ValueObjectCraft\ValueObject;
use InvalidArgumentException;

class PlaceLocationValueObject implements ValueObject
{

    public function __construct(
        private string $locality,
        private string $country,
        private ?string $region = null,
        private ?string $city = null,
        private ?string $postalCode = null
    ) {
    }

    public function getLocality(): string
    {
        return $this->locality;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function isSame(ValueObject $object): bool
    {
        if (!$object instanceof self) {
            return false;
        }

        return $this->locality === $object->getLocality()
            && $this->country === $object->getCountry()
            && $this->region === $object->getRegion()
            && $this->city === $object->getCity()
            && $this->postalCode === $object->getPostalCode();
    }

    public static function fromNative($native): self
    {
        if (!is_array($native)) {
            throw new InvalidArgumentException('Invalid native data provided.');
        }

        if (!isset($native['locality'], $native['country'])) {
            throw new InvalidArgumentException('Locality and country values are required.');
        }

        return new static(
            (string) $native['locality'],
            (string) $native['country'],
            isset($native['region']) ? (string) $native['region'] : null,
            isset($native['city']) ? (string) $native['city'] : null,
            isset($native['postalCode']) ? (string) $native['postalCode'] : null
        );
    }

    public function toNative(): array
    {
        $native = [
            'locality' => $this->locality,
            'country' => $this->country,
        ];

        if ($this->region !== null) {
            $native['region'] = $this->region;
        }

        if ($this->city !== null) {
            $native['city'] = $this->city;
        }

        if ($this->postalCode !== null) {
            $native['postalCode'] = $this->postalCode;
        }

        return $native;
    }

    public function __toString(): string
    {
        $parts = [];

        if ($this->locality !== '') {
            $parts[] = $this->locality;
        }

        if ($this->city !== null) {
            $parts[] = $this->city;
        }

        if ($this->region !== null) {
            $parts[] = $this->region;
        }

        if ($this->country !== '') {
            $parts[] = $this->country;
        }

        return implode(', ', $parts);
    }

    public function jsonSerialize(): array
    {
        return $this->toNative();
    }
}
