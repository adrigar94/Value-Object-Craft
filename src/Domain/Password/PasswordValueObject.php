<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Domain\Password;

use Adrigar94\ValueObjectCraft\Primitive\String\StringValueObject;

class PasswordValueObject extends StringValueObject
{
    protected static function getMinLength(): int
    {
        return 8;
    }

    protected static function getMaxLength(): int
    {
        return 255;
    }

    protected function ensureIsValid(string $value): void
    {
        parent::ensureIsValid($value);
        $this->ensureContainsRequiredCharacters($value);
    }

    private function ensureContainsRequiredCharacters(string $value): void
    {
        if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*\W).+$/', $value)) {
            throw new PasswordRequirementsException();
        }
    }

    public function encode(): string
    {
        return password_hash($this->value(), PASSWORD_DEFAULT);
    }

    public function verify(string $encodedPassword): bool
    {
        return password_verify($this->value(), $encodedPassword);
    }
}
