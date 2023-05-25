<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Test\Domain\Email;

use Adrigar94\ValueObjectCraft\Domain\Email\EmailValueObject;
use Adrigar94\ValueObjectCraft\Domain\Email\InvalidEmailException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(EmailValueObject::class)]
class EmailValueObjectTest extends TestCase
{
    public function testValidEmail(): void
    {
        $email = 'test@example.com';
        $emailValueObject = new EmailValueObject($email);

        $this->assertSame($email, $emailValueObject->value());
    }

    public function testInvalidEmail(): void
    {
        $this->expectException(InvalidEmailException::class);

        $email = 'invalid-email';
        new EmailValueObject($email);
    }
}