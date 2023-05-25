<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Primitive\Int;

use DomainException;

class IntTooLargeException extends DomainException
{
    public function __construct(int $maxValue, int $code = 400, ?\Throwable $previous = null)
    {
        $message = sprintf('Integer is too large. Maximum value required: %d', $maxValue);
        parent::__construct($message, $code, $previous);
    }
}