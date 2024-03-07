<?php

declare(strict_types=1);

namespace Biforb4\CurrencyConversion\Tests\Functional\Domain;

use Biforb4\CurrencyConversion\Domain\CurrencyConversion\ExchangeTransactionFactory;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Amount;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Currency;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\CurrencyRates\CurrencyRateRepository;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\CurrencyRates\ExchangeCalculator;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\FeeCalculationStrategy\PurchaseFeeProcessor;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\FeeCalculationStrategy\SaleFeeProcessor;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Money;
use Override;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ExchangeTransactionTest extends TestCase
{
    public static function saleDataProvider(): array
    {
        return [
            '100 EUR Sale for GBP' => [
                new Money(new Amount(10000), new Currency('EUR')),
                new Money(new Amount(15521), new Currency('GBP'))
            ],
            '100 GBP Sale for EUR' => [
                new Money(new Amount(10000), new Currency('GBP')),
                new Money(new Amount(15278), new Currency('EUR'))
            ]
        ];
    }


    #[DataProvider('saleDataProvider')]
    public function testSale(Money $source, Money $expectedTarget): void
    {
        $factory = new ExchangeTransactionFactory(
            [new PurchaseFeeProcessor(), new SaleFeeProcessor()],
            new ExchangeCalculator($this->getCurrencyRateRepository())
        );

        $exchangeTransaction = $factory->createSaleTransaction($source, $expectedTarget->getCurrency());
        $event = $exchangeTransaction->execute();
        $resultTargetMoney = $event->targetMoney;
        $this->assertTrue($expectedTarget->equals($resultTargetMoney));
    }

    public static function purchaseDataProvider(): array
    {
        return [
            '100 EUR Purchase for GBP' => [
                new Money(new Amount(10000), new Currency('EUR')),
                new Money(new Amount(15835), new Currency('GBP'))
            ],
            '100 GBP Purchase for EUR' => [
                new Money(new Amount(10000), new Currency('GBP')),
                new Money(new Amount(15586), new Currency('EUR'))
            ]
        ];
    }

    #[DataProvider('purchaseDataProvider')]
    public function testPurchase(Money $source, Money $expectedTarget): void
    {
        $factory = new ExchangeTransactionFactory(
            [new PurchaseFeeProcessor(), new SaleFeeProcessor()],
            new ExchangeCalculator($this->getCurrencyRateRepository())
        );

        $exchangeTransaction = $factory->createPurchaseTransaction($source, $expectedTarget->getCurrency());
        $event = $exchangeTransaction->execute();
        $resultTargetMoney = $event->targetMoney;

        $this->assertTrue($expectedTarget->equals($resultTargetMoney));
    }

    private function getCurrencyRateRepository(): CurrencyRateRepository
    {
        return new class implements CurrencyRateRepository {
            #[Override]
            public function getOneFor(
                Currency $source,
                Currency $target
            ): float {
                return match (true) {
                    $source->toString() === 'EUR' && $target->toString() === 'GBP' => 1.5678,
                    $source->toString() === 'GBP' && $target->toString() === 'EUR' => 1.5432,
                };
            }
        };
    }
}
