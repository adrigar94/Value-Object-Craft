<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Primitive\Int;

use DomainException;

class IntTooSmallException extends DomainException
{
    public function __construct(int $minValue, int $code = 400, ?\Throwable $previous = null)
    {
        $message = sprintf('Integer is too small. Minimum value required: %d', $minValue);
        parent::__construct($message, $code, $previous);
    }
}