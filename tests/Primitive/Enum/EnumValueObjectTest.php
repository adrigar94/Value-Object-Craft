<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Test\Primitive\Enum;

use Adrigar94\ValueObjectCraft\Primitive\Enum\EnumOptionNotAvailableException;
use Adrigar94\ValueObjectCraft\Primitive\Enum\EnumValueObject;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

class userRoles extends EnumValueObject
{
    public const ADMIN = 'admin';
    public const USER = 'user';
    protected function valueMapping(): array
    {
        return [
            self::ADMIN => 'Admin User',
            self::USER => 'Regular User',
        ];
    }
}
#[CoversClass(EnumValueObject::class)]
class EnumValueObjectTest extends TestCase
{

    public function testValidValue(): void
    {
        $value = 'admin';
        $enumValueObject = new userRoles($value);

        $this->assertSame($value, $enumValueObject->value());
    }

    public function testValidValueFromStatic(): void
    {
        $value = 'admin';
        $enumValueObject = userRoles::ADMIN();
        $this->assertSame($value, $enumValueObject->value());
    }

    public function testEnumOptionNotAvailableException(): void
    {
        $this->expectException(EnumOptionNotAvailableException::class);

        $value = 'guest';
        $enumValueObject = new userRoles($value);
    }

    public function testGetDisplayedValue(): void
    {
        $value = 'admin';
        $expectedDisplayedValue = 'Admin User';
        $enumValueObject = new userRoles($value);

        $this->assertSame($expectedDisplayedValue, $enumValueObject->getDisplayedValue());
    }

    public function testToString(): void
    {
        $value = 'admin';
        $expectedString = 'Admin User';
        $enumValueObject = new userRoles($value);

        $this->assertSame($expectedString, (string) $enumValueObject);
    }
}
