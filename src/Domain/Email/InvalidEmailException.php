<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Domain\Email;

use DomainException;

class InvalidEmailException extends DomainException
{
    public function __construct(string $email, int $code = 400, ?\Throwable $previous = null)
    {
        $message = sprintf('%s is an invalid email', $email);
        parent::__construct($message, $code, $previous);
    }
}