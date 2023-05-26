<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Domain\Password;

use InvalidArgumentException;

class PasswordRequirementsException extends InvalidArgumentException
{
    public function __construct(int $code = 400, ?\Throwable $previous = null)
    {
        $message = 'The password must contain at least one lowercase letter, one uppercase letter, one digit, and one special character.';
        parent::__construct($message, $code, $previous);
    }
}