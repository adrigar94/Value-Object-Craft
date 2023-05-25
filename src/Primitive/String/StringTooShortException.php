<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Primitive\String;

use DomainException;

class StringTooShortException extends DomainException
{
    public function __construct(int $minLength, string $className, int $code = 400, ?\Throwable $previous = null)
    {
        $message = sprintf('%s is too short. Minimum length required: %d', $className, $minLength);
        parent::__construct($message, $code, $previous);
    }
}