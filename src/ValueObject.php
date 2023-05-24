<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft;

use JsonSerializable;
use Stringable;

interface ValueObject extends Stringable, JsonSerializable
{
    public function isSame(ValueObject $object): bool;

    public static function fromNative($native);

    public function toNative();
}
