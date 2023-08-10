<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Tests\Domain\Location;

use Adrigar94\ValueObjectCraft\Domain\Location\CoordsValueObject;
use Adrigar94\ValueObjectCraft\Domain\Location\GeoLocationValueObject;
use Adrigar94\ValueObjectCraft\Domain\Location\PlaceLocationValueObject;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;


#[CoversClass(GeoLocationValueObject::class)]
class GeoLocationValueObjectTest extends TestCase
{
    public function testCanBeCreated(): void
    {
        $locality = 'New York';
        $country = 'United States';
        $region = 'New York';
        $city = 'New York City';
        $postalCode = '10001';
        $location = new PlaceLocationValueObject($locality, $country, $region, $city, $postalCode);


        $latitude = 41.6705909;
        $longitude = 2.791671;
        $coords = new CoordsValueObject($latitude, $longitude);
        $geoLocation = new GeoLocationValueObject($coords, $location);


        $this->assertInstanceOf(CoordsValueObject::class, $geoLocation->getCoords());
        $this->assertSame($latitude, $geoLocation->getCoords()->getLatitude());
        $this->assertSame($longitude, $geoLocation->getCoords()->getLongitude());

        $this->assertInstanceOf(PlaceLocationValueObject::class, $geoLocation->getLocation());
        $this->assertSame($locality, $geoLocation->getLocation()->getLocality());
        $this->assertSame($country, $geoLocation->getLocation()->getCountry());
        $this->assertSame($region, $geoLocation->getLocation()->getRegion());
        $this->assertSame($city, $geoLocation->getLocation()->getCity());
        $this->assertSame($postalCode, $geoLocation->getLocation()->getPostalCode());
    }


    public function testCanBeComparedForEquality(): void
    {
        $locality = 'New York';
        $country = 'United States';
        $region = 'New York';
        $city = 'New York City';
        $postalCode = '10001';
        $location = new PlaceLocationValueObject($locality, $country, $region, $city, $postalCode);


        $latitude = 41.6705909;
        $longitude = 2.791671;
        $coords = new CoordsValueObject($latitude, $longitude);

        $latitude = 41.6705909;
        $longitude = 2.7916713;

        $geoLocation1 = new GeoLocationValueObject($coords, $location);
        $geoLocation2 = new GeoLocationValueObject($coords, $location);

        $coords2 = new CoordsValueObject($latitude, $longitude);
        $geoLocation3 = new GeoLocationValueObject($coords2, $location);

        $this->assertTrue($geoLocation1->isSame($geoLocation2));
        $this->assertFalse($geoLocation1->isSame($geoLocation3));
    }
}
