<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Test\Domain\Name;

use Adrigar94\ValueObjectCraft\Domain\Name\NameValueObject;
use Adrigar94\ValueObjectCraft\Primitive\String\StringTooLongException;
use Adrigar94\ValueObjectCraft\Primitive\String\StringTooShortException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(NameValueObject::class)]
class NameValueObjectTest extends TestCase
{
    public function testValidValue(): void
    {
        $value = 'John Doe';
        $nameValueObject = new NameValueObject($value);

        $this->assertSame($value, $nameValueObject->value());
    }

    public function testStringTooShortException(): void
    {
        $this->expectException(StringTooShortException::class);

        $value = 'J';
        $nameValueObject = new NameValueObject($value);
    }

    public function testStringTooLongException(): void
    {
        $this->expectException(StringTooLongException::class);

        $value = 'This name is too long. It exceeds the maximum allowed length.';
        $nameValueObject = new NameValueObject($value);
    }
}