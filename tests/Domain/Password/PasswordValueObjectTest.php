<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Test\Domain\Password;

use Adrigar94\ValueObjectCraft\Domain\Password\PasswordValueObject;
use Adrigar94\ValueObjectCraft\Domain\Password\PasswordRequirementsException;
use Adrigar94\ValueObjectCraft\Primitive\String\StringTooShortException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PasswordValueObject::class)]
class PasswordValueObjectTest extends TestCase
{
    public function testValidPasswordValueObject(): void
    {
        $passwordValue = 'MySecurePassword123!';
        $password = new PasswordValueObject($passwordValue);

        $this->assertInstanceOf(PasswordValueObject::class, $password);
    }

    public function testInvalidShortPasswordValueObject(): void
    {
        $this->expectException(StringTooShortException::class);

        $passwordValue = 'Abc12!';
        new PasswordValueObject($passwordValue);
    }

    public function testInvalidPasswordMissingLowercase(): void
    {
        $this->expectException(PasswordRequirementsException::class);

        $passwordValue = 'SECURE123!';
        new PasswordValueObject($passwordValue);
    }

    public function testInvalidPasswordMissingUppercase(): void
    {
        $this->expectException(PasswordRequirementsException::class);

        $passwordValue = 'secure123!';
        new PasswordValueObject($passwordValue);
    }

    public function testInvalidPasswordMissingDigit(): void
    {
        $this->expectException(PasswordRequirementsException::class);

        $passwordValue = 'SecurePassword!';
        new PasswordValueObject($passwordValue);
    }

    public function testInvalidPasswordMissingSpecialCharacter(): void
    {
        $this->expectException(PasswordRequirementsException::class);

        $passwordValue = 'SecurePassword123';
        new PasswordValueObject($passwordValue);
    }

    public function testVerifyPasswordValueObject(): void
    {
        $passwordValue = 'MySecurePassword123!';
        $password = new PasswordValueObject($passwordValue);

        $this->assertTrue($password->verify($passwordValue));
    }
}