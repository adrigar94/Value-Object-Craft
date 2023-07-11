<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Primitive\Enum;

use RuntimeException;

class EnumOptionNotAvailableException extends RuntimeException
{
    public function __construct(string $value, int $code = 400, ?\Throwable $previous = null)
    {
        $message = sprintf('Option "%s" is not available', $value);
        parent::__construct($message, $code, $previous);
    }
}