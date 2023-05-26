<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Test\Domain\Uuid;

use Adrigar94\ValueObjectCraft\Domain\Uuid\UuidValueObject;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(UuidValueObject::class)]
class UuidValueObjectTest extends TestCase
{
    public function testValidUuid(): void
    {
        $uuid = 'a4b9fb6e-2093-4f3f-89d1-04ca4f32d50e';
        $uuidValueObject = new UuidValueObject($uuid);

        $this->assertSame($uuid, $uuidValueObject->value());
    }

    public function testInvalidUuid(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $uuid = 'invalid-uuid';
        new UuidValueObject($uuid);
    }

    public function testRandomUuid(): void
    {
        $uuidValueObject = UuidValueObject::random();

        $this->assertIsString($uuidValueObject->value());
    }

    public function testIsSame(): void
    {
        $uuid1 = 'a4b9fb6e-2093-4f3f-89d1-04ca4f32d50e';
        $uuid2 = 'a4b9fb6e-2093-4f3f-89d1-04ca4f32d50e';

        $uuidValueObject1 = new UuidValueObject($uuid1);
        $uuidValueObject2 = new UuidValueObject($uuid2);

        $this->assertTrue($uuidValueObject1->isSame($uuidValueObject2));
    }

    public function testToString(): void
    {
        $uuid = 'a4b9fb6e-2093-4f3f-89d1-04ca4f32d50e';
        $uuidValueObject = new UuidValueObject($uuid);

        $this->assertSame($uuid, (string) $uuidValueObject);
    }

    public function testJsonSerialize(): void
    {
        $uuid = 'a4b9fb6e-2093-4f3f-89d1-04ca4f32d50e';
        $uuidValueObject = new UuidValueObject($uuid);

        $this->assertSame($uuid, $uuidValueObject->jsonSerialize());
    }

    public function testFromNative(): void
    {
        $uuid = 'a4b9fb6e-2093-4f3f-89d1-04ca4f32d50e';
        $uuidValueObject = UuidValueObject::fromNative($uuid);

        $this->assertSame($uuid, $uuidValueObject->value());
    }

    public function testToNative(): void
    {
        $uuid = 'a4b9fb6e-2093-4f3f-89d1-04ca4f32d50e';
        $uuidValueObject = new UuidValueObject($uuid);

        $this->assertSame($uuid, $uuidValueObject->toNative());
    }
}
