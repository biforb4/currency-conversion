<?php

declare(strict_types=1);

namespace Biforb4\CurrencyConversion\Tests\Unit\Domain\CurrencyConversion\Transaction\CurrencyRates;

use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Amount;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Currency;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\CurrencyRates\CurrencyRateRepository;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\CurrencyRates\ExchangeCalculator;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Money;
use Override;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ExchangeCalculatorTest extends TestCase
{
    private CurrencyRateRepository|MockObject $repository;

    #[Override]
    protected function setUp(): void
    {
        $this->repository = $this->createMock(CurrencyRateRepository::class);
    }


    public function testCalculate(): void
    {
        //given
        $sourceCurrency = new Currency('GBP');
        $targetCurrency = new Currency('EUR');
        $this->repository->expects($this->once())
            ->method('getOneFor')
            ->with($sourceCurrency, $targetCurrency)
            ->willReturn(1.01);

        //when
        $sut = new ExchangeCalculator($this->repository);
        $result = $sut->calculate(new Money(new Amount(100), $sourceCurrency), $targetCurrency);

        //then
        $this->assertSame('EUR', $result->getCurrency()->toString());
        $this->assertSame(101, $result->getAmountInMinorUnit());
    }
}
