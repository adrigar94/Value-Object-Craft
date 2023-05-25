<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Test\Primitive\Float;

use Adrigar94\ValueObjectCraft\Primitive\Float\FloatTooSmallException;
use Adrigar94\ValueObjectCraft\Primitive\Float\FloatTooLargeException;
use Adrigar94\ValueObjectCraft\Primitive\Float\FloatValueObject;
use PHPUnit\Framework\TestCase;

/**
 * @covers FloatValueObject
 */
class FloatValueObjectTest extends TestCase
{
    public function testValidValue(): void
    {
        $value = 3.14;
        $floatValueObject = new class($value) extends FloatValueObject
        {
            protected static function getMinValue(): float
            {
                return 0.0;
            }

            protected static function getMaxValue(): float
            {
                return 10.0;
            }
        };

        $this->assertSame($value, $floatValueObject->value());
    }

    public function testFloatTooSmallException(): void
    {
        $this->expectException(FloatTooSmallException::class);

        $value = -0.014;
        $floatValueObject = new class((float) $value) extends FloatValueObject
        {
            protected static function getMinValue(): float
            {
                return 0.0;
            }

            protected static function getMaxValue(): float
            {
                return 10.0;
            }
        };
    }

    public function testFloatTooLargeException(): void
    {
        $this->expectException(FloatTooLargeException::class);

        $value = 10.001;
        $floatValueObject = new class($value) extends FloatValueObject
        {
            protected static function getMinValue(): float
            {
                return 0.0;
            }

            protected static function getMaxValue(): float
            {
                return 10.0;
            }
        };
    }
}