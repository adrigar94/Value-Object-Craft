<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Test\Domain\Currency;

use Adrigar94\ValueObjectCraft\Domain\Currency\CurrencyValueObject;
use Adrigar94\ValueObjectCraft\Primitive\Enum\EnumOptionNotAvailableException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(CurrencyValueObject::class)]
class CurrencyValueObjectTest extends TestCase
{
    
    public function testValidValue(): void
    {
        $value = CurrencyValueObject::Euro;

        $currencyValueObject = new CurrencyValueObject($value);

        $this->assertSame($value, $currencyValueObject->value());
    }

    public function testEnumOptionNotAvailableException(): void
    {
        $this->expectException(EnumOptionNotAvailableException::class);

        $value = 'Galactic Credit Standard';
        $currencyValueObject = new CurrencyValueObject($value);
    }

    
    public function testGetDisplayedValue(): void
    {
        $value = CurrencyValueObject::Euro;
        $expectedDisplayedValue = "EUR";
        $currencyValueObject = new CurrencyValueObject($value);

        $this->assertSame($expectedDisplayedValue, $currencyValueObject->getDisplayedValue());
    }
    
    public function testGetCurrencyNumber(): void
    {
        $value = CurrencyValueObject::Euro;
        $expectedNumber = "978";
        $currencyValueObject = new CurrencyValueObject($value);

        $this->assertSame($expectedNumber, $currencyValueObject->valueToCurrencyNumber());
    }
    
    public function testToString(): void
    {
        $value = CurrencyValueObject::Euro;
        $expectedString = 'EUR';
        $currencyValueObject = new CurrencyValueObject($value);

        $this->assertSame($expectedString, (string) $currencyValueObject);
    }
}