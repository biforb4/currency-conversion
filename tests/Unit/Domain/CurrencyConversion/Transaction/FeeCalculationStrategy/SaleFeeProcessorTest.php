<?php

declare(strict_types=1);

namespace Biforb4\CurrencyConversion\Tests\Unit\Domain\CurrencyConversion\Transaction\FeeCalculationStrategy;

use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Amount;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Currency;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\FeeCalculationStrategy\SaleFeeProcessor;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Money;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Type;
use PHPUnit\Framework\TestCase;

class SaleFeeProcessorTest extends TestCase
{

    public function testFeeIsSubtracted(): void
    {
        $money = new Money(new Amount(100), new Currency('EUR'));

        $sut = new SaleFeeProcessor();

        $result = $sut->processFee($money);

        $this->assertSame(99, $result->getAmountInMinorUnit());
        $this->assertSame('EUR', $result->getCurrency()->toString());
    }

    public function testSupportsSaleType(): void
    {
        $sut = new SaleFeeProcessor();

        $this->assertTrue($sut->supports(Type::SALE));
    }
}
