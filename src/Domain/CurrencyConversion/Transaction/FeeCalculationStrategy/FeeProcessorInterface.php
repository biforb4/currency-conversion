<?php

declare(strict_types=1);

namespace Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\FeeCalculationStrategy;

use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Money;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Type;

interface FeeProcessorInterface
{
    public function processFee(Money $money): Money;

    public function supports(Type $enum): bool;
}
