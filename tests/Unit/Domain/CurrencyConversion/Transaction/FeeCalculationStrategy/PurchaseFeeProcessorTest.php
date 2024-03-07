<?php

declare(strict_types=1);

namespace Biforb4\CurrencyConversion\Tests\Unit\Domain\CurrencyConversion\Transaction\FeeCalculationStrategy;

use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Amount;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Currency;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\FeeCalculationStrategy\PurchaseFeeProcessor;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Money;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Type;
use PHPUnit\Framework\TestCase;

class PurchaseFeeProcessorTest extends TestCase
{

    public function testFeeIsAdded(): void
    {
        $money = new Money(new Amount(100), new Currency('EUR'));

        $sut = new PurchaseFeeProcessor();

        $result = $sut->processFee($money);

        $this->assertSame(101, $result->getAmountInMinorUnit());
        $this->assertSame('EUR', $result->getCurrency()->toString());
    }

    public function testSupportsPurchaseType(): void
    {
        $sut = new PurchaseFeeProcessor();

        $this->assertTrue($sut->supports(Type::PURCHASE));
    }
}
