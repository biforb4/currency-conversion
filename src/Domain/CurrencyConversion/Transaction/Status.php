<?php

declare(strict_types=1);

namespace Biforb4\CurrencyConversion\Domain\CurrencyConversion\Transaction;

enum Status
{
    case NEW;
    case EXECUTED;
}
