<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Domain\Location;

use Adrigar94\ValueObjectCraft\ValueObject;
use InvalidArgumentException;

class CoordsValueObject implements ValueObject
{
    private float $latitude;
    private float $longitude;

    public function __construct(float $latitude, float $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function isSame(ValueObject $object): bool
    {
        if (!$object instanceof self) {
            return false;
        }

        return $this->latitude === $object->getLatitude() && $this->longitude === $object->getLongitude();
    }

    public static function fromNative($native): self
    {
        if (!is_array($native)) {
            throw new InvalidArgumentException('Invalid native data provided.');
        }

        if (!isset($native['latitude'], $native['longitude'])) {
            throw new InvalidArgumentException('Latitude and longitude values are required.');
        }

        return new self((float) $native['latitude'], (float) $native['longitude']);
    }

    public function toNative()
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }

    public function __toString(): string
    {
        return $this->latitude . ', ' . $this->longitude;
    }

    public function jsonSerialize()
    {
        return $this->toNative();
    }
}
