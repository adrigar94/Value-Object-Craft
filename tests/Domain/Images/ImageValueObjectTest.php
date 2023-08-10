<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Test\Domain\Images;

use Adrigar94\ValueObjectCraft\Domain\Images\ImageValueObject;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ImageValueObject::class)]
class ImageValueObjectTest extends TestCase
{
    public function testCreateImage(): void
    {
        $url = 'https://example.com/image.jpg';
        $alt = 'Example Image';

        $image = ImageValueObject::create($url, $alt);

        $this->assertInstanceOf(ImageValueObject::class, $image);
        $this->assertSame($url, $image->getUrl());
        $this->assertSame($alt, $image->getAlt());
    }

    public function testIsSame(): void
    {
        $url = 'https://example.com/image.jpg';
        $alt = 'Example Image';

        $image1 = ImageValueObject::create($url, $alt);
        $image2 = ImageValueObject::create($url, $alt);
        $image3 = ImageValueObject::create('https://example.com/other.jpg', 'Other Image');

        $this->assertTrue($image1->isSame($image2));
        $this->assertFalse($image1->isSame($image3));
    }

    public function testToString(): void
    {
        $url = 'https://example.com/image.jpg';
        $alt = 'Example Image';

        $image = ImageValueObject::create($url, $alt);

        $this->assertSame($url, (string)$image);
    }

    public function testJsonSerialize(): void
    {
        $url = 'https://example.com/image.jpg';
        $alt = 'Example Image';

        $image = ImageValueObject::create($url, $alt);

        $expectedArray = [
            'id' => $image->getId()->value(),
            'url' => $url,
            'alt' => $alt,
        ];
        $this->assertSame($expectedArray, $image->jsonSerialize());
    }
}
