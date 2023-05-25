<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Test\Primitive\Int;

use Adrigar94\ValueObjectCraft\Primitive\Int\IntTooSmallException;
use Adrigar94\ValueObjectCraft\Primitive\Int\IntTooLargeException;
use Adrigar94\ValueObjectCraft\Primitive\Int\IntValueObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers IntValueObject
 */
class IntValueObjectTest extends TestCase
{
    public function testValidValue(): void
    {
        $value = 42;
        $intValueObject = new class($value) extends IntValueObject
        {
            protected static function getMinValue(): int
            {
                return 0;
            }

            protected static function getMaxValue(): int
            {
                return 100;
            }
        };

        $this->assertSame($value, $intValueObject->value());
    }

    public function testIntTooSmallException(): void
    {
        $this->expectException(IntTooSmallException::class);

        $value = -5;
        $intValueObject = new class($value) extends IntValueObject
        {
            protected static function getMinValue(): int
            {
                return 0;
            }

            protected static function getMaxValue(): int
            {
                return 100;
            }
        };
    }

    public function testIntTooLargeException(): void
    {
        $this->expectException(IntTooLargeException::class);

        $value = 150;
        $intValueObject = new class($value) extends IntValueObject
        {
            protected static function getMinValue(): int
            {
                return 0;
            }

            protected static function getMaxValue(): int
            {
                return 100;
            }
        };
    }
}