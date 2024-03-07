<?php

declare(strict_types=1);

namespace Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction;

enum Type: string
{
    case SALE = 'sale';
    case PURCHASE = 'purchase';
}
