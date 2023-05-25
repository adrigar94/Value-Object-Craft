<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Domain\Name;

use Adrigar94\ValueObjectCraft\Primitive\String\StringValueObject;

class NameValueObject extends StringValueObject
{
    protected static function getMinLength(): int
    {
        return 2;
    }

    protected static function getMaxLength(): int
    {
        return 60;
    }
}
