<?php

declare(strict_types=1);

namespace Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\CurrencyRates;

use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Amount;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Currency;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Money;
use Override;

class ExchangeCalculator implements ExchangeCalculatorInterface
{
    private CurrencyRateRepository $repository;

    public function __construct(CurrencyRateRepository $repository)
    {
        $this->repository = $repository;
    }

    #[Override]
    public function calculate(Money $source, Currency $targetCurrency): Money
    {
        $rate = $this->repository->getOneFor($source->getCurrency(), $targetCurrency);
        $value = $source->getAmountInMinorUnit() * $rate;

        return new Money(Amount::fromFloat($value), $targetCurrency);
    }
}
