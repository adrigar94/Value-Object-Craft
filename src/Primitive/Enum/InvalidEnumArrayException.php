<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Primitive\Enum;

use DomainException;

class InvalidEnumArrayException extends DomainException
{
    public function __construct(int $code = 400, ?\Throwable $previous = null)
    {
        parent::__construct('Invalid value provided. Expected EnumValueObject array.', $code, $previous);
    }
}