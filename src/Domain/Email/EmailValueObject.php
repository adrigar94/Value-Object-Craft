<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Domain\Email;

use Adrigar94\ValueObjectCraft\Primitive\String\StringValueObject;

class EmailValueObject extends StringValueObject
{
    protected static function getMinLength(): int
    {
        return 5;
    }

    protected static function getMaxLength(): int
    {
        return 255;
    }

    protected function ensureIsValid(string $value): void
    {
        parent::ensureIsValid($value);
        $this->ensureIsEmailValid($value);
    }

    protected function ensureIsEmailValid(string $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidEmailException($value);
        }
    }
}