<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Test\Domain\Location;

use Adrigar94\ValueObjectCraft\Domain\Location\CoordsValueObject;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CoordsValueObject::class)]
class CoordsValueObjectTest extends TestCase
{
    public function testValidCoords(): void
    {
        $latitude = 41.6705909;
        $longitude = 2.791671;

        $coords = new CoordsValueObject($latitude, $longitude);

        $this->assertInstanceOf(CoordsValueObject::class, $coords);
        $this->assertSame($latitude, $coords->getLatitude());
        $this->assertSame($longitude, $coords->getLongitude());
    }

    public function testInvalidCoords(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $latitude = 'invalid';
        $longitude = 2.791671;

        CoordsValueObject::fromNative([$latitude, $longitude]);
    }

    public function testIsSame(): void
    {
        $latitude = 41.6705909;
        $longitude = 2.791671;

        $coords1 = new CoordsValueObject($latitude, $longitude);
        $coords2 = new CoordsValueObject($latitude, $longitude);
        $coords3 = new CoordsValueObject(40.948136, -4.117684);

        $this->assertTrue($coords1->isSame($coords2));
        $this->assertFalse($coords1->isSame($coords3));
    }

    public function testToString(): void
    {
        $latitude = 41.6705909;
        $longitude = 2.791671;

        $coords = new CoordsValueObject($latitude, $longitude);

        $expectedString = $latitude . ', ' . $longitude;
        $this->assertSame($expectedString, (string)$coords);
    }

    public function testJsonSerialize(): void
    {
        $latitude = 41.6705909;
        $longitude = 2.791671;

        $coords = new CoordsValueObject($latitude, $longitude);

        $expectedArray = [
            'latitude' => $latitude,
            'longitude' => $longitude,
        ];
        $this->assertSame($expectedArray, $coords->jsonSerialize());
    }
}
