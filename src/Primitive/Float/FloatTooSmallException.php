<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Primitive\Float;

use DomainException;

class FloatTooSmallException extends DomainException
{
    public function __construct(float $minValue, int $code = 400, ?\Throwable $previous = null)
    {
        $message = sprintf('Number is too small. Minimum value required: %f', $minValue);
        parent::__construct($message, $code, $previous);
    }
}