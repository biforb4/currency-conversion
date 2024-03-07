<?php

declare(strict_types=1);

namespace Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\CurrencyRates;

use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Currency;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Money;

interface ExchangeCalculatorInterface
{
    public function calculate(Money $source, Currency $targetCurrency): Money;
}
