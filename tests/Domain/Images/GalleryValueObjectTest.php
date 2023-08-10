<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Test\Domain\Images;

use Adrigar94\ValueObjectCraft\Domain\Images\GalleryValueObject;
use Adrigar94\ValueObjectCraft\Domain\Images\ImageValueObject;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;


#[CoversClass(GalleryValueObject::class)]
class GalleryValueObjectTest extends TestCase
{
    public function testAddImage(): void
    {
        $image1 = ImageValueObject::create('url1', 'alt1');
        $image2 = ImageValueObject::create('url2', 'alt2');
        $image3 = ImageValueObject::create('url3', 'alt3');

        $gallery = new GalleryValueObject($image1, $image2);
        $gallery->addImage($image3);

        $this->assertCount(3, $gallery->getImages());
        $this->assertSame($image1, $gallery->getImages()[0]);
        $this->assertSame($image2, $gallery->getImages()[1]);
        $this->assertSame($image3, $gallery->getImages()[2]);
    }

    public function testRemoveImage(): void
    {
        $image1 = ImageValueObject::create('url1', 'alt1');
        $image2 = ImageValueObject::create('url2', 'alt2');

        $gallery = new GalleryValueObject($image1, $image2);
        $gallery->removeImage($image1);

        $this->assertCount(1, $gallery->getImages());
        $this->assertSame($image2, $gallery->getImages()[0]);
    }

    public function testReorderImages(): void
    {
        $image1 = ImageValueObject::create('url1', 'alt1');
        $image2 = ImageValueObject::create('url2', 'alt2');

        $gallery = new GalleryValueObject($image1, $image2);
        $gallery->reorderImages([$image2->getId()->value(), $image1->getId()->value()]);

        $this->assertSame($image2, $gallery->getImages()[0]);
        $this->assertSame($image1, $gallery->getImages()[1]);
    }

    public function testIsSame(): void
    {
        $image1 = ImageValueObject::create('url1', 'alt1');
        $image2 = ImageValueObject::create('url2', 'alt2');
        $image3 = ImageValueObject::create('url3', 'alt3');

        $gallery1 = new GalleryValueObject($image1, $image2);
        $gallery2 = new GalleryValueObject($image1, $image2);
        $gallery3 = new GalleryValueObject($image2, $image3);

        $this->assertTrue($gallery1->isSame($gallery2));
        $this->assertFalse($gallery1->isSame($gallery3));
    }

    public function testToString(): void
    {
        $image1 = ImageValueObject::create('url1', 'alt1');
        $image2 = ImageValueObject::create('url2', 'alt2');

        $gallery = new GalleryValueObject($image1, $image2);

        $expectedString = json_encode([$image1->toNative(), $image2->toNative()]);
        $this->assertSame($expectedString, (string)$gallery);
    }

    public function testJsonSerialize(): void
    {
        $image1 = ImageValueObject::create('url1', 'alt1');
        $image2 = ImageValueObject::create('url2', 'alt2');

        $gallery = new GalleryValueObject($image1, $image2);

        $expectedArray = [$image1->toNative(), $image2->toNative()];
        $this->assertSame($expectedArray, $gallery->jsonSerialize());
    }
}
