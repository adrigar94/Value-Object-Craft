<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Primitive;

use DomainException;

class StringTooShortException extends DomainException
{
    public function __construct(int $minLength, int $code = 400, ?\Throwable $previous = null)
    {
        $message = sprintf('String is too short. Minimum length required: %d', $minLength);
        parent::__construct($message, $code, $previous);
    }
}