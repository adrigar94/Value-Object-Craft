<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Domain\Images;

use Adrigar94\ValueObjectCraft\ValueObject;

class GalleryValueObject implements ValueObject
{
    private array $images;

    public function __construct(ImageValueObject ...$images)
    {
        $this->images = $images;
    }

    public function getImages(): array
    {
        return $this->images;
    }

    public function addImage(ImageValueObject $image): void
    {
        $this->images[] = $image;
    }

    public function removeImage(ImageValueObject $image): void
    {
        $index = array_search($image, $this->images, true);
        if ($index !== false) {
            array_splice($this->images, $index, 1);
        }
    }

    public function reorderImages(array $idsNewOrder): void
    {
        $orderedImages = [];
        foreach ($idsNewOrder as $id) {
            foreach ($this->images as $image) {
                if ($image->getId()->value() === $id) {
                    $orderedImages[] = $image;
                    break;
                }
            }
        }

        $this->images = $orderedImages;
    }

    public function isSame(ValueObject $object): bool
    {
        if (!$object instanceof self) {
            return false;
        }

        return $this->getImages() === $object->getImages();
    }

    public static function fromNative($native): self
    {
        $imageObjects = [];
        foreach ($native as $imageData) {
            $imageObjects[] = ImageValueObject::fromNative($imageData);
        }

        return new static(...$imageObjects);
    }

    public function toNative(): array
    {
        $nativeImages = [];
        foreach ($this->getImages() as $image) {
            $nativeImages[] = $image->toNative();
        }

        return $nativeImages;
    }

    public function __toString(): string
    {
        return json_encode($this->toNative());
    }

    public function jsonSerialize(): array
    {
        return $this->toNative();
    }
}
