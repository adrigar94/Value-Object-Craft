<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Primitive\Float;

use DomainException;

class FloatTooLargeException extends DomainException
{
    public function __construct(float $maxValue, int $code = 400, ?\Throwable $previous = null)
    {
        $message = sprintf('Number is too large. Maximum value required: %f', $maxValue);
        parent::__construct($message, $code, $previous);
    }
}