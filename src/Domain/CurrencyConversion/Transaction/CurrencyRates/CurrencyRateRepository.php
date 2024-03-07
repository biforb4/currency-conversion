<?php

declare(strict_types=1);

namespace Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\CurrencyRates;

use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Currency;

interface CurrencyRateRepository
{
    public function getOneFor(Currency $source, Currency $target): float;
}
