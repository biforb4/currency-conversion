<?php

declare(strict_types=1);

namespace Biforb4\CurrencyConversion\Domain\CurrencyConversion;

use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Id;
use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Money;

class ExchangeTransactionExecutedEvent
{
    public function __construct(public Id $id, public Money $sourceMoney, public Money $targetMoney)
    {
    }
}
