<?php

declare(strict_types=1);

namespace Adrigar94\ValueObjectCraft\Test\Domain\Price;

use Adrigar94\ValueObjectCraft\Domain\Currency\CurrencyValueObject;
use Adrigar94\ValueObjectCraft\Domain\Price\PriceValueObject;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PriceValueObject::class)]
class PriceValueObjectTest extends TestCase
{
    private CurrencyValueObject $currency;

    protected function setUp(): void
    {
        $this->currency = new CurrencyValueObject(CurrencyValueObject::Euro);
    }

    public function testCreatePrice(): void
    {
        $priceNumber = 123.55;
        $price = PriceValueObject::createPrice($priceNumber, $this->currency);
        $this->assertInstanceOf(PriceValueObject::class, $price);
        $this->assertSame($priceNumber, $price->getPrice());
    }
}
