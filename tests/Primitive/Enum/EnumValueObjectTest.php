<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Test\Primitive\Enum;

use Adrigar94\ValueObjectCraft\Primitive\Enum\EnumOptionNotAvailableException;
use Adrigar94\ValueObjectCraft\Primitive\Enum\EnumValueObject;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(EnumValueObject::class)]
class EnumValueObjectTest extends TestCase
{
    public function testValidValue(): void
    {
        $value = 'admin';
        $enumValueObject = new class($value) extends EnumValueObject
        {
            protected function valueMapping(): array
            {
                return [
                    'admin' => 'Admin User',
                    'user' => 'Regular User',
                ];
            }
        };

        $this->assertSame($value, $enumValueObject->value());
    }

    public function testEnumOptionNotAvailableException(): void
    {
        $this->expectException(EnumOptionNotAvailableException::class);

        $value = 'guest';
        $enumValueObject = new class($value) extends EnumValueObject
        {
            protected function valueMapping(): array
            {
                return [
                    'admin' => 'Admin User',
                    'user' => 'Regular User',
                ];
            }
        };
    }

    public function testGetDisplayedValue(): void
    {
        $value = 'admin';
        $expectedDisplayedValue = 'Admin User';
        $enumValueObject = new class($value) extends EnumValueObject
        {
            protected function valueMapping(): array
            {
                return [
                    'admin' => 'Admin User',
                    'user' => 'Regular User',
                ];
            }
        };

        $this->assertSame($expectedDisplayedValue, $enumValueObject->getDisplayedValue());
    }

    public function testToString(): void
    {
        $value = 'admin';
        $expectedString = 'Admin User';
        $enumValueObject = new class($value) extends EnumValueObject
        {
            protected function valueMapping(): array
            {
                return [
                    'admin' => 'Admin User',
                    'user' => 'Regular User',
                ];
            }
        };

        $this->assertSame($expectedString, (string) $enumValueObject);
    }
}