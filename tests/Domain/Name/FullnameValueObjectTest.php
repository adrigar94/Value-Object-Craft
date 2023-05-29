<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Test\Domain\Name;

use Adrigar94\ValueObjectCraft\Domain\Name\FullnameValueObject;
use Adrigar94\ValueObjectCraft\Domain\Name\NameValueObject;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(FullnameValueObject::class)]
class FullnameValueObjectTest extends TestCase
{
    public function testValidValue(): void
    {
        $name = new NameValueObject('John');
        $surname = new NameValueObject('Doe');
        $fullname = new FullnameValueObject($name, $surname);

        $this->assertSame($name, $fullname->name());
        $this->assertSame($surname, $fullname->surname());
    }

    public function testCreate(): void
    {
        $name = 'John';
        $surname = 'Doe';
        $fullname = FullnameValueObject::create($name, $surname);

        $this->assertSame($name, $fullname->name()->value());
        $this->assertSame($surname, $fullname->surname()->value());
    }

    public function testIsSame(): void
    {
        $name1 = new NameValueObject('John');
        $surname1 = new NameValueObject('Doe');
        $fullname1 = new FullnameValueObject($name1, $surname1);

        $name2 = new NameValueObject('John');
        $surname2 = new NameValueObject('Doe');
        $fullname2 = new FullnameValueObject($name2, $surname2);

        $this->assertTrue($fullname1->isSame($fullname2));
    }

    public function testIsNotSame(): void
    {
        $name1 = new NameValueObject('John');
        $surname1 = new NameValueObject('Doe');
        $fullname1 = new FullnameValueObject($name1, $surname1);

        $name2 = new NameValueObject('Jane');
        $surname2 = new NameValueObject('Smith');
        $fullname2 = new FullnameValueObject($name2, $surname2);

        $this->assertFalse($fullname1->isSame($fullname2));
    }

    public function testFromNative(): void
    {
        $json = '{"name": "John", "surname": "Doe"}';
        $fullname = FullnameValueObject::fromNative($json);

        $this->assertInstanceOf(FullnameValueObject::class, $fullname);
        $this->assertSame('John', $fullname->name()->value());
        $this->assertSame('Doe', $fullname->surname()->value());
    }

    public function testToNative(): void
    {
        $name = new NameValueObject('John');
        $surname = new NameValueObject('Doe');
        $fullname = new FullnameValueObject($name, $surname);

        $expectedJson = '{"name":"John","surname":"Doe"}';
        $this->assertSame($expectedJson, $fullname->toNative());
    }

    public function testToString(): void
    {
        $name = new NameValueObject('John');
        $surname = new NameValueObject('Doe');
        $fullname = new FullnameValueObject($name, $surname);

        $expectedString = 'John Doe';
        $this->assertSame($expectedString, (string) $fullname);
    }

    public function testJsonSerialize(): void
    {
        $name = new NameValueObject('John');
        $surname = new NameValueObject('Doe');
        $fullname = new FullnameValueObject($name, $surname);

        $expectedJson = '{"name":"John","surname":"Doe"}';
        $this->assertSame($expectedJson, $fullname->jsonSerialize());
    }
}
