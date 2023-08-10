<?php

namespace Adrigar94\ValueObjectCraft\Domain\Images;

use Adrigar94\ValueObjectCraft\Domain\Uuid\UuidValueObject;
use Adrigar94\ValueObjectCraft\ValueObject;

class ImageValueObject implements ValueObject
{

    public function __construct(
        private UuidValueObject $id,
        private string $url,
        private string $alt
    ) {
    }

    public static function create(string $url, string $alt): self
    {
        $uuid = UuidValueObject::random();
        return new static($uuid, $url, $alt);
    }

    public function getId(): UuidValueObject
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getAlt(): string
    {
        return $this->alt;
    }
    public function isSame(ValueObject $object): bool
    {
        if (!$object instanceof ImageValueObject) {
            return false;
        }

        return $this->getUrl() === $object->getUrl() && $this->getAlt() === $object->getAlt();
    }

    public static function fromNative($native)
    {
        return new static(
            UuidValueObject::fromNative($native['id']),
            $native['url'],
            $native['alt']
        );
    }

    public function toNative()
    {
        return [
            'id' => $this->id->value(),
            'url' => $this->url,
            'alt' => $this->alt,
        ];
    }

    public function __toString()
    {
        return $this->url;
    }

    public function jsonSerialize()
    {
        return $this->toNative();
    }
}
