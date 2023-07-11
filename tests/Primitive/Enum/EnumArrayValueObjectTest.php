<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Test\Primitive\Enum;

use Adrigar94\ValueObjectCraft\Primitive\Enum\EnumArrayValueObject;
use Adrigar94\ValueObjectCraft\Primitive\Enum\EnumValueObject;
use Adrigar94\ValueObjectCraft\Primitive\Enum\InvalidEnumArrayException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

class RoleEnum extends EnumValueObject
{
    protected function valueMapping(): array
    {
        return [
            'USER' => 'User',
            'ADMIN' => 'Admin',
            'GUEST' => 'Guest',
        ];
    }
}

class RoleArrayValueObject extends EnumArrayValueObject
{
    static protected function enumClass(): string
    {
        return RoleEnum::class;
    }
}

#[CoversClass(EnumArrayValueObject::class)]
class EnumArrayValueObjectTest extends TestCase
{
    public function testValidValue(): void
    {
        $values = [new RoleEnum('USER'), new RoleEnum('ADMIN')];
        $enumArrayValueObject = new RoleArrayValueObject($values);

        $this->assertSame($values, $enumArrayValueObject->values());
    }

    public function testAddValue(): void
    {
        $values = [new RoleEnum('USER')];
        $enumArrayValueObject = new RoleArrayValueObject($values);
        $enumArrayValueObject->add(new RoleEnum('ADMIN'));

        $this->assertCount(2, $enumArrayValueObject->values());
        $this->assertContains('USER', $enumArrayValueObject->toNative());
        $this->assertContains('ADMIN', $enumArrayValueObject->toNative());
    }

    public function testInvalidValue(): void
    {
        $this->expectException(InvalidEnumArrayException::class);

        $values = [new RoleEnum('USER'), new class("INVALID") extends EnumValueObject
        {
            protected function valueMapping(): array
            {
                return [
                    'INVALID' => 'Invalid User'
                ];
            }
        }];
        new RoleArrayValueObject($values);
    }

    public function testIsSame(): void
    {
        $values1 = [new RoleEnum('USER'), new RoleEnum('ADMIN')];
        $values2 = [new RoleEnum('USER'), new RoleEnum('ADMIN')];
        $enumArrayValueObject1 = new RoleArrayValueObject($values1);
        $enumArrayValueObject2 = new RoleArrayValueObject($values2);

        $this->assertTrue($enumArrayValueObject1->isSame($enumArrayValueObject2));
    }

    public function testIsNotSame(): void
    {
        $values1 = [new RoleEnum('USER'),  new RoleEnum('ADMIN')];
        $values2 = [new RoleEnum('USER'),  new RoleEnum('GUEST')];
        $enumArrayValueObject1 = new RoleArrayValueObject($values1);
        $enumArrayValueObject2 = new RoleArrayValueObject($values2);

        $this->assertFalse($enumArrayValueObject1->isSame($enumArrayValueObject2));
    }

    public function testFromNative(): void
    {
        $values = ['USER', 'ADMIN'];
        $enumArrayValueObject = RoleArrayValueObject::fromNative($values);

        $this->assertInstanceOf(RoleArrayValueObject::class, $enumArrayValueObject);
        $this->assertSame($values, $enumArrayValueObject->toNative());
    }

    public function testToNative(): void
    {
        $values = ['USER',  'ADMIN'];
        $enumArrayValueObject = RoleArrayValueObject::fromNative($values);

        $this->assertSame($values, $enumArrayValueObject->toNative());
    }

    public function testToString(): void
    {
        $values = [new RoleEnum('USER'),  new RoleEnum('ADMIN')];
        $enumArrayValueObject = new RoleArrayValueObject($values);

        $this->assertSame('User, Admin', (string) $enumArrayValueObject);
    }
}