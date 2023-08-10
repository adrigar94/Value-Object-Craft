<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Tests\Domain\Location;

use Adrigar94\ValueObjectCraft\Domain\Location\PlaceLocationValueObject;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;


#[CoversClass(PlaceLocationValueObject::class)]
class PlaceLocationValueObjectTest extends TestCase
{
    public function testCanBeCreated(): void
    {
        $locality = 'New York';
        $country = 'United States';
        $region = 'New York';
        $city = 'New York City';
        $postalCode = '10001';

        $location = new PlaceLocationValueObject($locality, $country, $region, $city, $postalCode);

        $this->assertInstanceOf(PlaceLocationValueObject::class, $location);
        $this->assertSame($locality, $location->getLocality());
        $this->assertSame($country, $location->getCountry());
        $this->assertSame($region, $location->getRegion());
        $this->assertSame($city, $location->getCity());
        $this->assertSame($postalCode, $location->getPostalCode());
    }

    public function testCanBeComparedForEquality(): void
    {
        $location1 = new PlaceLocationValueObject('London', 'United Kingdom', 'England', 'London', 'SW1A 1AA');
        $location2 = new PlaceLocationValueObject('London', 'United Kingdom', 'England', 'London', 'SW1A 1AA');
        $location3 = new PlaceLocationValueObject('Paris', 'France', 'Île-de-France', 'Paris', '75000');

        $this->assertTrue($location1->isSame($location2));
        $this->assertFalse($location1->isSame($location3));
    }

    public function testCanBeConvertedToNativeArray(): void
    {
        $location = new PlaceLocationValueObject('Berlin', 'Germany', 'Berlin', null, '10178');

        $expected = [
            'locality' => 'Berlin',
            'country' => 'Germany',
            'region' => 'Berlin',
            'postalCode' => '10178',
        ];

        $this->assertSame($expected, $location->toNative());
    }

    public function testCanBeCreatedFromNativeArray(): void
    {
        $native = [
            'locality' => 'Tokyo',
            'country' => 'Japan',
            'region' => 'Tokyo',
            'city' => 'Chiyoda',
            'postalCode' => '100-0001',
        ];

        $location = PlaceLocationValueObject::fromNative($native);

        $this->assertInstanceOf(PlaceLocationValueObject::class, $location);
        $this->assertSame($native['locality'], $location->getLocality());
        $this->assertSame($native['country'], $location->getCountry());
        $this->assertSame($native['region'], $location->getRegion());
        $this->assertSame($native['city'], $location->getCity());
        $this->assertSame($native['postalCode'], $location->getPostalCode());
    }

    public function testCanBeConvertedToString(): void
    {
        $location = new PlaceLocationValueObject('Sydney', 'Australia', 'New South Wales', 'Sydney');

        $expected = 'Sydney, Sydney, New South Wales, Australia';

        $this->assertSame($expected, (string) $location);
    }

    public function testCanBeSerializedToJson(): void
    {
        $location = new PlaceLocationValueObject('Toronto', 'Canada', 'Ontario', 'Toronto', 'M5V 1J9');

        $expected = json_encode([
            'locality' => 'Toronto',
            'country' => 'Canada',
            'region' => 'Ontario',
            'city' => 'Toronto',
            'postalCode' => 'M5V 1J9',
        ]);

        $this->assertSame($expected, json_encode($location));
    }
}
