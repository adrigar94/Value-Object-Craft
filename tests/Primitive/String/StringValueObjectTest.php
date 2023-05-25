<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Test\Primitive\String;

use Adrigar94\ValueObjectCraft\Primitive\String\StringTooLongException;
use Adrigar94\ValueObjectCraft\Primitive\String\StringTooShortException;
use Adrigar94\ValueObjectCraft\Primitive\String\StringValueObject;
use PHPUnit\Framework\TestCase;

class StringValueObjectTest extends TestCase
{
    public function testValidValue(): void
    {
        $value = 'Hello, World!';
        $stringValueObject = new class($value) extends StringValueObject {
            protected static function getMinLength(): int {
                return 5;
            }

            protected static function getMaxLength(): int {
                return 15;
            }
        };

        $this->assertSame($value, $stringValueObject->value());
    }

    public function testStringTooShortException(): void
    {
        $this->expectException(StringTooShortException::class);
        
        $value = 'Hi';
        $stringValueObject = new class($value) extends StringValueObject {
            protected static function getMinLength(): int {
                return 5;
            }

            protected static function getMaxLength(): int {
                return 15;
            }
        };
    }

    public function testStringTooLongException(): void
    {
        $this->expectException(StringTooLongException::class);
        
        $value = 'This string is too long';
        $stringValueObject = new class($value) extends StringValueObject {
            protected static function getMinLength(): int {
                return 5;
            }

            protected static function getMaxLength(): int {
                return 15;
            }
        };
    }
}
