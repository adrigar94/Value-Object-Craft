<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Domain\Password;

use Adrigar94\ValueObjectCraft\Primitive\String\StringValueObject;

class PasswordValueObject extends StringValueObject
{

    public function __construct(string $value, bool $isHashed = false)
    {
        parent::__construct($value);

        $this->value = $value;
        if(!$isHashed){
            $this->value = $this->encode($value);
        }
    }
    
    public static function fromHashed(string $hashed): self
    {
        return new static($hashed, true);
    }

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

    public function encode(string $plainPassword): string
    {
        return password_hash($plainPassword, PASSWORD_DEFAULT);
    }

    public function verify(string $plainPassword): bool
    {
        return password_verify($plainPassword, $this->value());
    }
}
