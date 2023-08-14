<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Domain\Location;

use Adrigar94\ValueObjectCraft\ValueObject;
use InvalidArgumentException;

class GeoLocationValueObject implements ValueObject
{

    public function __construct(private CoordsValueObject $coords, private PlaceLocationValueObject $location)
    {
    }

    public function getCoords(): CoordsValueObject
    {
        return $this->coords;
    }

    public function getLocation(): PlaceLocationValueObject
    {
        return $this->location;
    }

    public function isSame(ValueObject $object): bool
    {
        if (!$object instanceof GeoLocationValueObject) {
            return false;
        }

        return $this->coords->isSame($object->getCoords()) && $this->location->isSame($object->getLocation());
    }

    public static function fromNative($native)
    {
        if (!is_array($native)) {
            throw new InvalidArgumentException('Invalid native data provided.');
        }

        if (!isset($native['coords'], $native['location'])) {
            throw new InvalidArgumentException('Coords and location values are required.');
        }

        $coords = CoordsValueObject::fromNative($native['coords']);
        $location = PlaceLocationValueObject::fromNative($native['location']);

        return new static($coords, $location);
    }

    public function toNative(): array
    {
        return [
            'coords' => $this->coords->toNative(),
            'location' => $this->location->toNative(),
        ];
    }

    public function __toString(): string
    {
        return $this->location->__toString() . ' (' . $this->coords->__toString() . ')';
    }

    public function jsonSerialize(): array
    {
        return $this->toNative();
    }
}
