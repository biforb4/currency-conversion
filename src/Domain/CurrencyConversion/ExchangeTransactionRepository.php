<?php

declare(strict_types=1);

namespace Biforb4\CurrencyConversion\Domain\CurrencyConversion;

use Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction\Id;

interface ExchangeTransactionRepository
{
    public function findOneById(Id $id);
    public function save(ExchangeTransaction $exchangeTransaction);
}
